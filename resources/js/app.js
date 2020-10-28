window.ASSET_URL = document.querySelector('head > link[rel=dns-prefetch]#ASSET_URL')
    .getAttribute('href')
    .replace(/\/+$/, '');

require("alpinejs");

const Prism = require("prismjs");
require("prismjs/components/prism-markup-templating");
require("prismjs/components/prism-php");
require("prismjs/plugins/line-numbers/prism-line-numbers");
Prism.highlightAll();

import Clipboard from "clipboard/src/clipboard";
new Clipboard("button[data-clipboard-text]");

window.twemoji = function (content) {
    const parse = require("twemoji").default.parse;
    parse(content, {
        base: window.ASSET_URL + "/vendor/twemoji/",
        folder: "svg",
        ext: ".svg",
    });
};
window.twemoji(document.body);