import React from "react";
import { createRoot } from "react-dom/client";

import App from "./App";

import { HashRouter } from "react-router-dom";

declare const ydtblib_link_in_bio_global: {
  root: string;
  cssURL: string;
};
const container = document.querySelector("#ydtblib-link-in-bio-root");
const shadowContainer = container!.attachShadow({ mode: "open" });
const shadowRootElement = document.createElement("div");
if (ydtblib_link_in_bio_global.cssURL) {
  const shadowStyleElement = document.createElement("link");
  shadowStyleElement.rel = "stylesheet";
  shadowStyleElement.type = "text/css";
  shadowStyleElement.href = ydtblib_link_in_bio_global.cssURL;
  shadowContainer.appendChild(shadowStyleElement);
}
shadowContainer.appendChild(shadowRootElement);

const root = createRoot(shadowRootElement);
root.render(
  <HashRouter>
    <App />
  </HashRouter>
);
