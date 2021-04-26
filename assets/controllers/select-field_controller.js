import {Controller} from "stimulus"
import ReactDOM from "react-dom";
import React from "react";
import SelectField from "../components/form/SelectField";

export default class extends Controller {
    static values = {
        widget: Object
    }

    connect() {
        ReactDOM.render(
            <SelectField widget={this.widgetValue} />,
            this.element
        )
    }
}
