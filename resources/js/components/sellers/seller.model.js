import {Model} from "../model";

export class SellerModel extends Model {

	set commission(value) {
		this._commission = (+value || 0).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
	}

	get commission() {
		return this._commission;
	}

	all () {
		return {
			name: this.name,
			email: this.email
		}
	}
}
