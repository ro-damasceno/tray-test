<template>
    <section>
        <h1>Vendedores</h1>

        <form v-on:submit="onSubmit($event)">

            <div class="row no-gutters">
                <div class="col-auto">
                    <div class="form-group">
                        <label for="query" class="sr-only">Filtro</label>
                        <input v-model="q" class="form-control" style="width: 250px" name="query" id="query" placeholder="Filtro" />
                        <small class="form-text text-muted">E-mail ou nome do vendedor.</small>
                    </div>
                </div>

                <div class="col-auto">
                    <button class="btn btn-primary">Buscar</button>
                </div>

                <div class="col-auto ml-auto">
                    <button class="btn btn-success" v-on:click="newSeller()">Novo Vendedor</button>
                </div>
            </div>

        </form>

        <div class="table-responsive" v-if="!!paginator">
            <table class="table table-striped" >
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Comissão</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                <tr v-for="seller of paginator.content()">
                    <td>{{seller.id}}</td>
                    <td>{{seller.name}}</td>
                    <td>{{seller.email}}</td>
                    <td>{{seller.commission}}</td>
                    <td>
                        <router-link class="text-uppercase flex-shrink-0" :to="'/sellers/'+seller.id">
                            <i class="fa fa-chevron-right"></i>
                        </router-link>
                    </td>
                </tr>
                </tbody>
            </table>

            <paginator-component v-on:paging="onPaging" v-bind:paginator="paginator && paginator.total > 0"></paginator-component>
        </div>

        <seller-edit-modal ref="dialog"></seller-edit-modal>
    </section>
</template>

<script>
    import {SellerRepository} from './seller.repository';

    const repository = new SellerRepository;

    export default {
		created() {
			this.page = this.$route.query.page || 1;
			this.q    = this.$route.query.q || null;
			this.find();
		},
        data() {
			return  {
				page: 1,
                per_page: 20,
                q: null,
				paginator: null
            }
        },
        methods: {
			onPaging(page) {
				this.page = page;
				this.find();

				this.updateRoute();
            },
			onSubmit ($event) {
				$event.preventDefault();
				this.page = 1;
				this.find();

				this.updateRoute();
            },
            find () {
				repository
                    .read({
                        page: this.page,
						per_page: this.per_page,
						q: this.q,
                    })
                    .then((paginator) => {
                        this.paginator = paginator;
                    });
            },
            newSeller () {
				this.$refs.dialog.show();
            },
            updateRoute () {
				let queries = {
					page: this.page
                };

				if (this.q) {
					queries.q = this.q;
                }
				this.$router.push({
					query: queries
				});
            }
        }
    }
</script>