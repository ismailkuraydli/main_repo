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
        soundPop = new Audio("bubble-pop.mp3");
        addButton = document.getElementById("add-button");
        addButton.addEventListener('click',this.addButtonListener, false);
        ToDoListApp.populateList();
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
        if(!ToDoListApp.formDataValidity(todoData)) {
            ToDoListApp.showInvalidButton();
        } else {
            ToDoListApp.addItem(todoData.get('title'),todoData.get('description'));
            localStorage.arrayTodo = JSON.stringify(ToDoListApp.arrayTodo);
            ToDoListApp.populateList();
            resetForm = document.getElementById('form-id');
            resetForm.reset();
        }
    },
    /**
     * method to display invalid input button
     */
    showInvalidButton() {
        invalidButton = document.getElementById('invalid-button');
        invalidButton.removeAttribute('class');
        invalidButton.setAttribute('class', 'bubble-div');
        hideButton = function(){
            invalidButton.setAttribute('class', 'hidden');
        }  
        
        invalidButton.addEventListener('click',hideButton,false); 
    },
    /**
     * Method to validate form fields
     * @param {*formElement} formData 
     */
    formDataValidity(formData) {
        formTitle = formData.get('title');
        formDescription = formData.get('description');
        if (formTitle == "" || formDescription == "") {
            return false;
        } else if (formTitle.length > 60) {
            return false;
        } else {
            return true;
        }
    },
    /**
     * Method to handle delete button click
     */
    deleteItemListener() {
        soundPop.play();
        ToDoListApp.deleteItem(this.value);
        ToDoListApp.updateStorage();
        this.parentElement.setAttribute('class',"pop-bubble");
        this.parentElement.parentElement.setAttribute('class',"pop-bubble");
        this.parentElement.innerHTML = "POP!!!";
        window.setTimeout(ToDoListApp.populateList,500);
    },
    /**
     * Function to populate list from localStorage
     */
    populateList() {
        list = document.getElementById("list-space");
        list.innerHTML= "";
        for(i = 0;i<ToDoListApp.arrayTodo.length;i++) { 
            
            titleInstance = ToDoListApp.arrayTodo[i].title;
            descriptionInstance = ToDoListApp.arrayTodo[i].description;
            dateAndTime = ToDoListApp.arrayTodo[i].timeAdded;
            divBlock = ToDoListApp.divBlockItem(
                titleInstance,dateAndTime,descriptionInstance,i)
            list.appendChild(divBlock);
        }
        ToDoListApp.setDeleteButtonListeners();
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
        div.setAttribute('class','todo-item bubble-div y2');
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
            "<div class=\"todo-item\">",
            "<div class=\"title\">",
                "<h2>"+title+"</h2>",
                "<h6>"+dateAndTime+"</h6>",
                "<h4>"+description+"</h4>",
            "</div>",
            "<button class=\"delete-button\" value=\""+index+"\">",
            "<h5>X</h5></button>",
        "</div>"
        ].join("");
        return divBlock;
    }
};
ToDoListApp.init();

