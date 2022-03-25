<template>
	<div class="row">
		<div class="col-lg-7 m-auto">
			<card title="Add Activity">
				<form @submit.prevent="add" @keydown="form.onKeydown($event)">
					<!-- Email -->
					<div class="mb-3 row">
						<label class="col-md-3 col-form-label text-md-end">Activity Name</label>
						<div class="col-md-7">
							<input v-model="form.activity_name"
								:class="{ 'is-invalid': form.errors.has('activity_name') }" class="form-control"
								type="text" name="activity_name">
							<has-error :form="form" field="activity_name" />
							<span class="text-danger" v-show="show_error">{{error_message}}</span>
						</div>
					</div>

					<div class="mb-3 row">
						<div class="col-md-7 offset-md-3 d-flex">
							<!-- Submit Button -->
							<v-button :loading="form.busy">
								Save
							</v-button>
						</div>
					</div>
				</form>
			</card>
		</div>
	</div>
</template>

<script>
	import Form from 'vform'

	export default {

		metaInfo() {
			return {
				title: 'Add Activity'
			}
		},

		data: () => ({
			form: new Form({
				activity_name: ''
			}),
			show_error: false,
			error_message: ''
		}),

		methods: {
			async add() {
				const {
					data
				} = await this.form.post('/api/add_activity')
				if (data.code == 200) {
					localStorage.removeItem('activities')
					this.$router.push({
						name: 'home'
					})
				} else {
					this.show_error = true;
					this.error_message = data.message;
				}
			},
		}
	}
</script>