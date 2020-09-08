<template>
    <div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(visitor, index) in visitors" :key="index" v-on:click="rowClicked(visitor)">
                    <td>{{ visitor.name }}</td>
                    <td>{{ visitor.age }}</td>
                    <td>{{ visitor.purpose }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>    
    export default {
        props: ['api_token'],
        data() {
            return {
                visitor: {},
                visitors: []
            }
        },
        created() {
            Echo.channel('new-visitor')
                .listen('NewVisitor', (payload) => {
                    console.log('New Visitor', payload);
                    this.visitors.push(payload.visitor);
                });

            axios.get(`/api/visitors/get?api_token=${this.api_token}`)
                .then((response) => {
                    this.visitors = response.data.data;
                })
                .catch(function(error) {
                    console.log(error.message);
                })
        },
        methods: {
            rowClicked(data) {
                console.log('Row Data', JSON.stringify(data));
            }
        }
    }
</script>

<style scoped>
    tbody tr {
        cursor: pointer;
    }
</style>
