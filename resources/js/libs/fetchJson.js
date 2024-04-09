window.fetchJson = async function(url, formData) {

	console.log({url})
    if(typeof formData === "object" && !(formData instanceof FormData)) {
        let formDataOnTheFly = new FormData();

        for ( var key in formData ) {
            formDataOnTheFly.append(key, formData[key]);
        }

        formData = formDataOnTheFly;
    }

    if(formData instanceof FormData) {
        formData.append('_token', window.csrf_token);
    }

    const response = await fetch(url.replace('http://', 'https://'), {
        method: formData ? 'POST' : 'GET',
        body: formData
    });

    return await response.json()
};
