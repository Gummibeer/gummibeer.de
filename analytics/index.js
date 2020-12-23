require('str-trim');
const platform = require('platform');

const CORS = {
    'Access-Control-Allow-Methods': 'GET, OPTIONS',
    'Access-Control-Allow-Origin': 'https://gummibeer.dev',
};

async function handleRequest(request) {
    try {
        const url = new URL(request.url);

        const origin = request.headers.get('origin');
        if (!origin) {
            throw new Error('Origin missing');
        }

        const location = new URL(url.searchParams.get('l'));
        const domain = new URL(origin).hostname;
        if (!DOMAINS.split(',').includes(domain)) {
            throw new Error('Unknown origin');
        }
        if (domain != location.hostname) {
            throw new Error('Domain mismatch');
        }

        const referer = new URL(url.searchParams.get('r'));

        const ua = request.headers.get('user-agent');
        if (!ua) {
            throw new Error('User-Agent missing');
        }
        const agent = platform.parse(ua);

        const data = {
            location: location.pathname.trim('/'),
            referer: referer.hostname,
            referer_url: referer,
            country: request.cf.country,
            browser: agent.name,
            browser_version: agent.version,
            os_name: agent.os.family,
            os_version: agent.os.version,
            at: (new Date).toISOString(),
        };

        /** @link https://cloud.google.com/iap/docs/authentication-howto */
        const oauth = await fetch('https://oauth2.googleapis.com/token', {
            method: 'POST',
            headers: {
                'content-type': 'application/json;charset=UTF-8',
            },
            body: JSON.stringify({
                grant_type: 'refresh_token',
                audience: OAUTH_CLIENT_ID,
                client_id: OAUTH_CLIENT_ID,
                client_secret: OAUTH_CLIENT_SECRET,
                refresh_token: OAUTH_REFRESH_TOKEN,
            }),
        });

        const SHEET_ID = '1d4Ar8Er1UBNQEmxk26T5JyxG0StQmf3-bRKvRs_sHmI';
        const TABLE_RANGE = domain + '!A2:I';
        await fetch(`https://sheets.googleapis.com/v4/spreadsheets/${SHEET_ID}/values/${TABLE_RANGE}:append?valueInputOption=RAW`, {
            method: 'POST',
            headers: {
                'content-type': 'application/json;charset=UTF-8',
                authorization: 'Bearer ' + (await oauth.json())['access_token'],
            },
            body: JSON.stringify({
                range: TABLE_RANGE,
                majorDimension: 'ROWS',
                values: [Object.values(data)],
            }),
        });

        return new Response(JSON.stringify(data), {
            status: 200,
            headers: CORS,
        });
    } catch (e) {
        return new Response(JSON.stringify({ error: e.message }), {
            status: 500,
            headers: CORS,
        });
    }
}

addEventListener('fetch', event => {
    event.respondWith(handleRequest(event.request));
});
