require("alpinejs");

const Prism = require("prismjs");
require("prismjs/components/prism-markup-templating");
require("prismjs/components/prism-php");
require("prismjs/components/prism-ini");
require("prismjs/plugins/line-numbers/prism-line-numbers");
Prism.highlightAll();

import Clipboard from "clipboard/src/clipboard";
new Clipboard("button[data-clipboard-text]");

import Fuse from "fuse.js/dist/fuse.basic.esm";
window._ = require("lodash");
window.search = {
  items: null,
  fuse: null,
  query: "",
  results: [],
  init() {
    let url = new URL(window.location);
    url.pathname = "blog/search.json";
    url.searchParams.set("t", Date.now());

    fetch(url.toString())
      .then((response) => response.json())
      .then((items) => {
        this.items = items;

        this.fuse = new Fuse(this.items, {
          includeScore: true,
          minMatchCharLength: 3,
          keys: ["title", "description", "categories"],
        });
      })
      .catch(console.error);
  },
  search() {
    if (this.fuse === null) {
      this.results = [];
      return false;
    }

    this.results = _(this.fuse.search(this.query))
      .orderBy("score", "desc")
      .take(3)
      .map((r) => r.item)
      .values();
  },
};
