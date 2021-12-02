import "./common/common.scss";
import "@lwc/synthetic-shadow";
import { createElement } from "lwc";
import Admin from "./components/admin/admin";

const appEl = createElement("z-admin", { is: Admin });
appEl.model = JSON.parse(model.replace(/\r\n/g, "\\n"));
document.body.appendChild(appEl);