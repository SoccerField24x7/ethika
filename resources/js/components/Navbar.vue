<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
        <div class="container">
            <a href="#" class="navbar-brand"><img src="images/ethika.png" height="75" /></a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/order">Create Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search">Search Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
	export default {
		name: "Navbar"
	}
</script>

<style scoped>

</style>
