<template>
  <div>
	  <form @submit.prevent="formSubmit">
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" class="form-control" v-model="question.title" id="title" placeholder="Title">
		</div>
		<div class="form-group">
			<label for="question">Question</label>
			<input type="text" class="form-control" v-model="question.question" id="question" placeholder="Question">
		</div>
		<button class="btn btn-success btn-block" >Add</button>
	  </form>
  </div>
</template>

<script>
export default {
	props: {
		api_token: {
			type: String,
			required: true
		},
		_question: {
			type: Object,
			required: false,
		}
	},
	data() {
		return {
			question: {
				id: 0,
				title: '',
				question: '',
			},
		}
	},
	methods: {
		formSubmit() {
			axios.post(`/api/question?api_token=${this.api_token}`, ( this.question ))
				.then((response) => {
					this.question.title = '';
					this.question.question = '';
					this.$emit('add');
				})
				.catch(function(error) {
					console.log(error.response);
				})
		},
	},
}
</script>