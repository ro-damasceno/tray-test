export class Model {

	constructor(attributes) {
		this.fill(attributes);
	}

	fill(attributes) {

		if (typeof attributes !== 'object') {
			return;
		}

		for (let index in attributes) {
			if (attributes.hasOwnProperty(index)) {
				this.setAttribute(index, attributes[index])
			}
		}
	}

	setAttribute (name, value) {
		this[name] = value;
	}

	/**
	 * @abstract
	 * */
	all() {}
}