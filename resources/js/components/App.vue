<template>
    <main class="main">
        <div>
            <h1>Vue component</h1>
            <p>Currency test {{new Date().toDateString()}}</p>
            <h4>Items: {{item}}</h4>
            <button type="button" class="button" @click="onClick">Click</button>
        </div>
    </main>
</template>
<script>
import axios from 'axios';

export default {
  data() {
    return {
      item: null,
      errors: []
    }
  },

  methods:{
    onClick: function(){
        axios.get(`http://127.0.0.1:8000/books/cronjob`)
        .then(response => {
            this.item = response.data.name;
        })
        .catch(e => {
            this.errors.push(e)
        })
    }
  }
}
</script>

<style lang="css">
.main{
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #a7f0ff;
    height: 100vh;
    width: 100vw;
}
.button{
    font-size: 20px;
    padding: 5px 10px;
    background-color:cadetblue;
    cursor:pointer;
}
</style>
