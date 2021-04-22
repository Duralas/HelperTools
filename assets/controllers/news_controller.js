import {Controller} from "stimulus"

export default class extends Controller {
    connect() {
        this.element.innerHTML = "L'aspect graphique se rajoute petit à petit !";
    }
}
