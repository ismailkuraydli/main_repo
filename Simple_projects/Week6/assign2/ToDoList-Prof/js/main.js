/**
 * Application object and initialization
 */
ToDoListApp = {
    arrayTodo : [],
    init : function() {
        if(!localStorage.arrayTodo) {
            this.arrayTodo = [];
            
        } else {
            console.log(localStorage.arrayTodo);
            this.arrayTodo = JSON.parse(localStorage.arrayTodo);
            
        }
        addButton = document.getElementById("add-button");
        addButton.addEventListener('click',this.addButtonListener, false);
        ToDoListApp.populateList(true);
        newestTab = document.getElementById('newest-tab');
        newestTab.focus();
        newestTab.addEventListener('click',function(){
            ToDoListApp.populateList(true)}, false);
        oldestTab = document.getElementById('oldest-tab');
        oldestTab.addEventListener('click',function(){
            ToDoListApp.populateList(false)}, false);
    },
    options : {
        weekday: "long",
        year: "numeric",
        month:"short",
        day:"numeric",
        hour:"2-digit",
        minute:"2-digit"
    },
    /**
     * Method to add an item to arrayToDo
     * @param string title, description
     */
    addItem(title,description) {
        this.arrayTodo.push({
                title: title,
                description: description,
                timeAdded: new Intl.DateTimeFormat("en-US",this.options).format(Date.now())
            })
    },
    /**
     * Method to update localStorage
     */
    updateStorage() {
        localStorage.arrayTodo = JSON.stringify(this.arrayTodo);
    },
    /**
     * Method to delete item from arrayToDo
     */
    deleteItem(index) {
        this.arrayTodo.splice(index,1);
    },
    /**
     * Method to handle Add button click
     */
    addButtonListener : function() {
        todoData = new FormData(document.querySelector('form'));
        ToDoListApp.invalidLabel(
            'description-invalid','','invalid hidden');
            ToDoListApp.invalidLabel(
                'title-invalid','','invalid hidden');
        if(!ToDoListApp.formDataValidity(todoData)) {
        } else {
            ToDoListApp.addItem(todoData.get('title'),todoData.get('description'));
            localStorage.arrayTodo = JSON.stringify(ToDoListApp.arrayTodo);
            ToDoListApp.insertOneDiv(ToDoListApp.arrayTodo.length-1);
            resetForm = document.getElementById('form-id');
            resetForm.reset();
        }
    },
    
    /**
     * Method to validate form fields
     * @param {*formElement} formData 
     */
    formDataValidity(formData) {
        formTitle = formData.get('title');
        formDescription = formData.get('description');
        if (formTitle == "") {
            ToDoListApp.invalidLabel(
                'title-invalid','*Required','invalid');
            return false;
        } else if (formTitle.length > 60) {
            ToDoListApp.invalidLabel(
                'title-invalid','*Title to long','invalid');
            return false;
        } else if (formDescription == ""){
            ToDoListApp.invalidLabel(
                'description-invalid','*Required','invalid');
            return false;
        } else {
            return true;
        }
    },
    /**
     * Set invalid html and show them
     */
    invalidLabel(id,innerText,classes) {
        invalidEmpty= document.getElementById(id);
        invalidEmpty.removeAttribute('class');
        invalidEmpty.setAttribute('class', classes);
        invalidEmpty.innerHTML = innerText;
    },
    /**
     * Method to handle delete button click
     */
    deleteItemListener() {
        ToDoListApp.deleteItem(this.value);
        ToDoListApp.updateStorage();
        deletedDiv = document.getElementById("item-"+this.value);
        deletedDiv.setAttribute('class','paper-material flow-out');
        window.setTimeout(ToDoListApp.populateList,500);
    },
    /**
     * Function to populate list from localStorage
     * @param {*bool} true for newest false for oldest
     */
    populateList(optionForDisplay) {
        list = document.getElementById("list-space");
        list.innerHTML= "";
        for(i = 0;i<ToDoListApp.arrayTodo.length;i++) { 
            titleInstance = ToDoListApp.arrayTodo[i].title;
            descriptionInstance = ToDoListApp.arrayTodo[i].description;
            dateAndTime = ToDoListApp.arrayTodo[i].timeAdded;
            divBlock = ToDoListApp.divBlockItem(
                titleInstance,dateAndTime,descriptionInstance,i);
            if(optionForDisplay) {
                list.prepend(divBlock);
            } else {
                list.appendChild(divBlock);
            }
            
        }
        ToDoListApp.setDeleteButtonListeners();
    },

    insertOneDiv(i) {
        list = document.getElementById("list-space");
        titleInstance = ToDoListApp.arrayTodo[i].title;
        descriptionInstance = ToDoListApp.arrayTodo[i].description;
        dateAndTime = ToDoListApp.arrayTodo[i].timeAdded;
        divBlock = ToDoListApp.divBlockItem(
            titleInstance,dateAndTime,descriptionInstance,i)
        list.prepend(divBlock);
        deleteButtons1 = document.getElementsByClassName("delete-button");
        deleteButtons1[0].addEventListener('click',ToDoListApp.deleteItemListener, false);
    },
    /**
     * Method that produces a todo display block
     * @param {*string} title 
     * @param {*string} dateAndTime 
     * @param {*string} description 
     * @param {*int} index 
     */
    divBlockItem(title,dateAndTime,description,index) {
        div = document.createElement('div');
        div.removeAttribute('class');
        div.setAttribute('class','paper-material flow-in');
        div.setAttribute('id',"item-"+i);
        div.innerHTML = ToDoListApp.getDivInnerHTML(
            titleInstance,dateAndTime,descriptionInstance,i);
            return div;
    },
    /**
     * Method to set each blocks event listener
     */
    setDeleteButtonListeners() {
        deleteButtons = document.getElementsByClassName("delete-button"); 
        for(i = 0; i< deleteButtons.length; i++) {
            deleteButtons[i].addEventListener('click',this.deleteItemListener, false);
        }
    },
    /**
     * HTML block with variable inputs
     * @param {*string} title 
     * @param {*string} dateAndTime 
     * @param {*string} description 
     * @param {*int} index 
     */
    getDivInnerHTML(title,dateAndTime,description,index) {
        var divBlock = [
        "<div class=\"title\">",
            "<h2>"+title+"</h2>",
            "<h6>"+dateAndTime+"</h6>",
            "<h4>"+description+"</h4>",
        "</div>",
        "<button class=\"delete-button\" value=\""+index+"\">",
        "-</button>"
        ].join("");
        return divBlock;
    }
};
ToDoListApp.init();

