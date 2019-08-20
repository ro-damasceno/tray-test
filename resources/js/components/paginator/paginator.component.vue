<template>
    <nav v-if="paginator">
        <ul class="pagination">

            <li class="page-item" v-bind:class="{disabled: !show_first_page}" >
                <a class="page-link" v-on:click="paging($event, 1)" href="?p=1">
                    Primeiro
                </a>
            </li>

            <li class="page-item" v-for="page of pages" v-bind:class="{ disabled: page === paginator.currentPage()}">
                <a class="page-link" v-on:click="paging($event, page)" :href="'?p='+page">{{page}}</a>
            </li>

            <li class="page-item" v-bind:class="{disabled: !show_last_page}">
                <a class="page-link" v-on:click="paging($event, paginator.lastPage())" :href="'?p='+paginator.lastPage()">
                    Último
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
	export default {
		data() {
			return {
				show_first_page: false,
				show_last_page: false,
				pages: []
			}
        },
		props: ['paginator'],
		watch: {
			paginator: {
				immediate: true,
				handler (newValue, oldValue)  {

					if (!newValue) {
						return []
                    }

					let from = newValue.currentPage()-2;
					if (from < 1) {
						from = 1;
					}

					let to = from+4;
					if (to > newValue.lastPage()) {
						to = newValue.lastPage();
					}

                    let range = to - from;
					if (range < 5 && from - range > 1) {
						from-=5-range;
                    }

					let pages = [];
					for(let i = from; i <= to ; i++) {
						pages.push(i);
					}

                    this.show_first_page = from > 1;
                    this.show_last_page  = to < newValue.lastPage();
					this.pages = pages;
				}
            }
        },
        methods: {
			paging($event, page) {

				$event.preventDefault();

				this.$emit('paging', page)
            }
        }
	}
</script>