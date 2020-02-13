import "./common/common.scss";
import "@lwc/synthetic-shadow";
import { createElement } from "lwc";
import Admin from "./components/admin/admin";

const appEl = createElement("z-admin", { is: Admin });
appEl.model = JSON.parse(model);
console.log(appEl.model);
document.body.appendChild(appEl);
