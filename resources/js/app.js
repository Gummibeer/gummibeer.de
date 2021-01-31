window.ASSET_URL = document.querySelector('head > link[rel=dns-prefetch]#ASSET_URL')
    .getAttribute('href')
    .replace(/\/+$/, '');

require("alpinejs");

const Prism = require("prismjs");
require("prismjs/components/prism-markup-templating");
require("prismjs/components/prism-php");
require("prismjs/components/prism-ini");
require("prismjs/components/prism-scss");
require("prismjs/plugins/line-numbers/prism-line-numbers");
Prism.highlightAll();

import Clipboard from "clipboard/src/clipboard";
new Clipboard("button[data-clipboard-text]");

window._ = require("lodash");
window.search = {
  items: null,
  fuse: null,
  query: "",
  results: [],
  search() {
    let url = new URL("https://search.gummibeer.dev");
    url.searchParams.set("q", this.query);
    url.searchParams.set("t", Date.now());

    fetch(url)
      .then((res) => res.json())
      .then((results) => {
        this.results = _(results)
          .orderBy("score", "asc")
          .take(3)
          .map((r) => r.item)
          .values();
      });
  },
};

window.twemoji = function (content) {
    const parse = require("twemoji").default.parse;
    parse(content, {
        base: window.ASSET_URL + "/vendor/twemoji/",
        folder: "svg",
        ext: ".svg",
    });
};
window.twemoji(document.body);