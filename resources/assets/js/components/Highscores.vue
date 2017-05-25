<template>
    <div>
        <h2 style="margin-bottom:15px;font-weight:bold;">Meeste tweets</h2>

        <input type="text" id="search" class="form-control" placeholder="Zoek jou @twitter">
        <div id="searchResult" style="display:none;">
            <div>
                <div class="profileImg"></div>
                <h1><span id="searchPos"></span> plaats!</h1>
                <div class="clearfix"></div>
            </div>
            <h3>Proficiat! Deel je overwinning:</h3>
            <div id="twitterBtn"></div>
        </div>
        <div id="noResults" style="display:none;">
            <h3>Helaas, je staat niet in de top 500 :(</h3>
        </div>
    </div>
</template>