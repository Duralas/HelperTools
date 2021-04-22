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
Array
    .from(document.querySelectorAll(".mdc-list"))
    .map(function (listElement) {
        (new mdc.list.MDCList(listElement))
            .listElements
            .map((listItemElement) => new mdc.ripple.MDCRipple(listItemElement));
    });

//endregion -- Implementations -----
