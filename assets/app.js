/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app-mdc.scss";

//region ----- Libraries -----

// Material Design
import * as mdc from "material-components-web";

//endregion -- Libraries -----

//region ----- Implementations -----

// Material Design - Listes => https://material.io/develop/web/components/lists
const mdcList = new mdc.list.MDCList(document.querySelector(".mdc-list"));
mdcList.listElements.map((listItemEl) => new mdc.ripple.MDCRipple(listItemEl));

//endregion -- Implementations -----
