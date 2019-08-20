import {Model} from "../model";

export class OrderModel extends Model {

	get commissionFormatted() {
		return (+this.commission || 0).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
	}

	get totalFormatted() {
		return (+this.total || 0).toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
	}

	all () {
		return {
			seller_id: this.seller_id,
			total: this.total
		}
	}
}
