import {Repository} from "../repository";
import {SellerModel} from "./seller.model";

export class SellerRepository extends Repository{

	getUrl() {
		return '/sellers';
	}

	makeModel(attributes) {
		return new SellerModel(attributes)
	}
}