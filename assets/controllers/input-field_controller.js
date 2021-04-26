import {Controller} from "stimulus"
import ReactDOM from "react-dom";
import React from "react";
import InputField from "../components/form/InputField";

export default class extends Controller {
    static values = {
        widget: Object
    }

    connect() {
        ReactDOM.render(
            <InputField widget={this.widgetValue} />,
            this.element
        )
    }
}
