<template>
	<div>
		<div class="float-right">
			<router-link :to="{ name: 'addActivity' }" class="small ms-auto my-auto">
				<button class="btn btn-primary">Add Activity</button>
			</router-link>
		</div>
		<br><br>
		<div class="clear-fix">
			<div class="text-danger" v-show="show_error">{{error_message}}</div>
			<table class="table table-responsive">
				<tr v-for="activity in activities" :key="activity.id">
					<td>
						<input type="checkbox" name="status" :checked="activity.status ? 'checked' : ''"
							@change="updateActivity($event, activity.id)">
						<span :class="activity.status ? 'completed' : ''">{{activity.activity_name}}</span>
					</td>
					<td>
						<a href="javascript:;" @click="removeActivity(activity.id)"><i class="fa fa-trash"
								aria-hidden="true"></i></a>
					</td>
				</tr>
			</table>
		</div>
	</div>
</template>

<script>
	import Button from '../../components/Button.vue'
	import axios from 'axios'

	export default {
		middleware: 'auth',
		components: {
			Button
		},
		metaInfo() {
			return {
				title: this.$t('home')
			}
		},

		data: () => ({
			activities: [],
			show_error: false,
			error_message: '',
			status: []
		}),
		methods: {
			async getActivities() {
				const {
					data
				} = await axios.get('/api/activities')
				this.activities = data
			},
			async removeActivity(id) {
				await axios.delete(`/api/remove_activity/?id=${id}`)
				.then(res => {
					if (res.data.code == 200) {
						localStorage.removeItem('activities')
						this.getActivities()
					} else {
						this.show_error = true;
						this.error_message = res.data.message;
					}
				})
				.catch(err => {
					console.log(err)
				})
			},
			async updateActivity(e, id) {
				await axios.patch(`/api/update_activity/?id=${id}`, {
					status: e.target.checked
				})
				.then(res => {
					console.log(res);
					if (res.data.code == 200) {
						localStorage.removeItem('activities')						
						this.getActivities()
					} else {
						this.show_error = true;
						this.error_message = res.data.message;
					}
				})
				.catch(err => {
					console.log(err)
				})
			}
		},
		mounted() {
			if (localStorage.getItem("activities")) {
				this.activities = JSON.parse(localStorage.getItem("activities"))
			} else {
				this.getActivities()
			}
		},
		watch: {
			activities: {
				handler() {
					localStorage.setItem('activities', JSON.stringify(this.activities))
				},
				deep: true
			}
		}
	}
</script>

<style scoped>
	.float-left {
		float: left;
	}

	.float-right {
		float: right;
	}

	.completed {
		text-decoration: line-through;
		font-weight: 700;
		color: blue;
	}
</style>