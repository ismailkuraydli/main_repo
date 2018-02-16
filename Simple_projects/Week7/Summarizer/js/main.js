
mySummerizerApp = {
    url : "",
    blogPostTitle : "",
    blogPostImage : "",
    init : function() {
        document.getElementById('url-form').reset();
        document.getElementById('Summary-tab').focus();
        submitUrlButton = document.getElementById('submit-url');
        submitUrlButton.addEventListener('click',mySummerizerApp.buttonClick,true)
    },
    /**
     * Actions for when button is clicked
     */
    buttonClick() {
        mySummerizerApp.refreshEverything();
        mySummerizerApp.setURL();
        mySummerizerApp.loadingButton(true);
       something = mySummerizerApp.getArticleData(mySummerizerApp.url).then(function(text){
            if(text == false) {
                mySummerizerApp.hideSummarySpace();
                mySummerizerApp.invalidLabel('url-invalid','*Invalid Medium URL','invalid')
                mySummerizerApp.loadingButton(false);
            } else {
                mySummerizerApp.aylienSummarizer(text).then(function(text){
                   mySummerizerApp.appendToHtml('summary-p','p',text);
                    mySummerizerApp.appendToHtml(
                        'title-h2','h2',mySummerizerApp.blogPostTitle);
                        mySummerizerApp.loadingButton(false);
                        mySummerizerApp.flowInSummarySpace();
               });
            }
       });
    },
    /**
     * Gets the element that holds the summary
     */
    getSummarySpace() {
        summarySpace1 = document.getElementById('summary-space');
        summarySpace1.removeAttribute("class");
        return summarySpace1;
    },
    /**
     * Sets summary space to flow in animation
     */
    flowInSummarySpace() {
        summarySpace = mySummerizerApp.getSummarySpace();
        summarySpace.setAttribute('class','paper-material flow-in');
    },
    /**
     * Sets summary space to flow out animation
     */
    flowOutSummarySpace() {
        summarySpace = mySummerizerApp.getSummarySpace();
        summarySpace.setAttribute('class','paper-material flow-out');
    },
    /**
     * Sets summary space to hidden
     */
    hideSummarySpace() {
        summarySpace = mySummerizerApp.getSummarySpace();
        summarySpace.setAttribute('class','paper-material hidden');
    },
    /**
     * Turns loading button on and off
     * @param {*bool} onOff true for on false for off
     */
    loadingButton(onOff) {
        invalidEmpty= document.getElementById('loading-spinner');
        if(onOff) {
            invalidEmpty.removeAttribute('class');
            invalidEmpty.setAttribute('class', 'spinner');
        } else {
            invalidEmpty.removeAttribute('class');
            invalidEmpty.setAttribute('class', 'spinner hidden');
        }
    },
    /**
     * Refreshes page elements
     */
    refreshEverything() {
       mySummerizerApp.invalidLabel(
        'url-invalid','','invalid hidden');
        divRefresh = document.getElementById('title-h2');
        window.setTimeout(divRefresh.innerText,5000,"");
        divRefresh = document.getElementById('summary-p');
        window.setTimeout(divRefresh.innerText,5000,"");
        mySummerizerApp.flowOutSummarySpace();
    },
    /**
     * Gets invalid tag element and sets inner text and classes
     * @param {*string} id 
     * @param {*string} innerText 
     * @param {*string} classes 
     */
    invalidLabel(id,innerText,classes) {
        invalidEmpty= document.getElementById(id);
        invalidEmpty.removeAttribute('class');
        invalidEmpty.setAttribute('class', classes);
        invalidEmpty.innerHTML = innerText;
    },
    /**
     * Appends an element to a given element with inner text specified
     * @param {*string} elementId 
     * @param {*string} elementToCreate 
     * @param {*string} innerContent 
     */
    appendToHtml(elementId,elementToCreate,innerContent) {
        divSummary = document.getElementById(elementId);
        divSummary.innerText = innerContent;
    },
    /**
     * Gets url from input and sets it to App object
     */
    setURL() {
        urlForm = document.getElementById('url-input');
        mySummerizerApp.url = urlForm.value;
    },
    /**
     * Gets summary from Aylien API
     * @param {*object} articleObject 
     */
    aylienSummarizer(articleObject) {
       summarizedTextPromise = this.fetchData(
           'Summarizer.php','article',articleObject)
           .then(function(text){
            return text;
        });
        return summarizedTextPromise;
    },
    /**
     * Gets page data for a given URL 
     * @param {*string} articleURL 
     */
    getArticleData(articleURL) {
       articleFromMediumPromise = this.fetchData('Proxy.php','url',articleURL).then(function(text){
            articleDoc = mySummerizerApp.textToDOM(text);
            articleFromMedium = mySummerizerApp.getMediumArticle(articleDoc);
            return articleFromMedium;
        })
        return articleFromMediumPromise;
    },
    /**
     * Sends POST request with parameters and returns promise
     * @param {*string} fetchFrom 
     * @param {*string} postTag 
     * @param {*any} postValue 
     */
    fetchData(fetchFrom,postTag,postValue) {
        formData = mySummerizerApp.createNewFormData(postTag,postValue);
        textReturnedPromise = fetch(fetchFrom,{
            method: 'POST',
            body: formData
        }).then(function(response) {
            return response.text();
        }).then (function(text){
            textReturned = text;
            return textReturned;
        })
        return textReturnedPromise;
    },
    /**
     * Creates new FormData object for POST
     * @param {*string} postTag 
     * @param {*any} postValue 
     */
    createNewFormData(postTag,postValue) {
        var newFormData = new FormData();
        postType = typeof postValue;
        if(postType == typeof {} ) {
            arrayOfProperties = Object.getOwnPropertyNames(postValue);
            arrayOfProperties.forEach(element => {
                newFormData.append(postTag+"-"+element,postValue[element]);
            });
        } else {
            newFormData.append(postTag,postValue);
        }
        return newFormData;
    },
    /**
     * Changes HTML text to DOM tree object
     * @param {*string} htmlText 
     */
    textToDOM(htmlText) {
        parser = new DOMParser();
        htmlDoc = parser.parseFromString(htmlText,'text/html');
        return htmlDoc;
    },
    /**
     * Gets medium article text and title from blogPost DOM tree
     * @param {*HTMLObject} mediumDoc 
     */
    getMediumArticle(mediumDoc) {
        if(!mySummerizerApp.blogPostValidation(mediumDoc)) {
            return false;
        }
        pElements = mediumDoc.getElementsByClassName('graf graf--p');
        articleTitle = mediumDoc.getElementsByClassName('graf--title');
        articleText = "";
        for(i=0;i<pElements.length;i++){
            articleSection = pElements[i].innerText;
            articleText = articleText + " " + articleSection;
        }
        article = {
            title: articleTitle[0].innerText,
            body: articleText
        }
        mySummerizerApp.blogPostTitle = article.title;
        return article;
    },
    /**
     * Validates if webpage is a medium blog post
     * @param {*HTMLObject} docDOM 
     */
    blogPostValidation(docDOM) {
        headOfPost = docDOM.getElementsByTagName('head')[0];
        prefixHead = headOfPost.getAttribute('prefix');
        if(prefixHead == null) {
            return false;
        }
        mediumPrefix = "medium-com:";
       if(prefixHead.indexOf(mediumPrefix)!== -1) {
           return true;
       }
       return false;
    }
}
mySummerizerApp.init();
