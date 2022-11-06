<template>
    <main class="main">
        <div v-if="isFetched">
            <h1>Vue component</h1>
            <p>Currency test {{new Date().toDateString()}}</p>
            <h4>Items: {{item}}</h4>
            <input type="checkbox" id="hasActiveNotifications" name="hasActiveNotifications" v-model="hasActiveNotifications" @change="onChange">
            <label for="vehicle1"> hasActiveNotifications</label>
        </div>
    </main>
</template>

<script>
import { ref } from "vue";
import axios from 'axios';

export default ({
    setup() {
    const item = ref(null);
    const isFetched = ref(false);
    const hasActiveNotifications = ref(false);

    const onChange = () => {
        axios.post(`http://127.0.0.1:8000/user-settings`, {
            hasActiveNotifications: Number(hasActiveNotifications.value),
            id: '636182a08392e0cb9f08b2b7'
        })
        .then(response => {
            console.log(response);
        })
        .catch(e => {
            console.log(e)
        })
    }

        axios.get(`http://127.0.0.1:8000/user-settings/636182a08392e0cb9f08b2b7`)
        .then(response => {
            item.value = response.data;
            isFetched.value = true;
            hasActiveNotifications.value = !!response.data?.hasActiveNotifications;
        })
        .catch(e => {
            console.log(e)
        })

    return {
        onChange,
        item,
        isFetched,
        hasActiveNotifications
    }
    }
});
</script>
<style lang="scss">
.main{
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #a7f0ff;
    height: 100vh;
    width: 100vw;
    padding: 5% 10%;
}
.button{
    font-size: 20px;
    padding: 5px 10px;
    background-color:cadetblue;
    cursor:pointer;
}

</style>
