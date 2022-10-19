<template>
    <main class="main">
        <div>
            <h1>Vue component</h1>
            <p>Currency test {{new Date().toDateString()}}</p>
        </div>
    </main>
</template>
<script>
export default {

}
</script>

<style lang="css">
.main{
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #7da0b1;
    height: 100vh;
    width: 100vw;
}
</style>
