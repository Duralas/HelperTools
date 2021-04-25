import {Controller} from "stimulus"
import ReactDOM from "react-dom";
import React from "react";
import ButtonField from "../components/form/ButtonField";

export default class extends Controller {
    static values = {
        widget: Object
    }

    connect() {
        ReactDOM.render(
            <ButtonField widget={this.widgetValue} />,
            this.element
        )
    }
}
