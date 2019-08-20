export class Paginator {

	constructor (data) {
		this.data = data;
	}

	content () {
		return this.data.data;
	}

	currentPage () {
		return this.data.current_page;
	}

	lastPage () {
		return this.data.last_page;
	}

	firstPageUrl () {
		return this.data.first_page_url;
	}

	prevPageUrl () {
		return this.data.prev_page_url;
	}

	nextPageUrl () {
		return this.data.next_page_url;
	}

	lastPageUrl () {
		return this.data.last_page_url;
	}
}