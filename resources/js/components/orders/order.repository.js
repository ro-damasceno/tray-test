import {Repository} from "../repository";
import {OrderModel} from "./order.model";

export class OrderRepository extends Repository{

	getUrl() {
		return '/orders';
	}

	makeModel(attributes) {
		return new OrderModel(attributes)
	}
}