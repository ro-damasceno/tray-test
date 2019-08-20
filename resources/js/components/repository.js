import {Paginator} from "./paginator/paginator";

/**
 * @abstract
 * */
export class Repository {

	/**
	 * @abstract
	 * */
	getUrl () {}

	/**
	 * @abstract
	 * */
	makeModel () {}

	read(params) {
		return axios.get(this.getUrl(), {
			params: params||{}}
		)
			.then((response) => {
				response.data.data = (response.data.data || []).map((record) => {
					return this.makeModel(record);
				});

				return new Paginator(response.data)
			});
	}

	findOne (id) {
		return axios.get(this.getUrl()+'/'+id)
			.then(
				(response) => {
					return this.makeModel(response.data);
				}
			);
	}

	/**
	 * @param {Model} model
	 * */
	create (model) {
		return axios.post(this.getUrl(), model.all())
			.then(
				(response) => {
					return this.makeModel(response.data);
				}
			);
	}

	/**
	 * @param {Model} model
	 * */
	update (model) {
		return axios.put(this.getUrl()+'/'+model.id, model.all())
			.then(
				(response) => {
					return this.makeModel(response.data);
				}
			);
	}

	/**
	 * @param {Model} model
	 * */
	save (model) {
		return model.id ? this.update(model) : this.create(model);
	}

	/**
	 * @param {number} id
	 * */
	delete (id) {
		return axios.delete(this.getUrl()+'/'+id);
	}
}