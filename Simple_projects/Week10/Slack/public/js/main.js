ChatApp = {
    /**
     * Options for date format
     */
    options : {
        weekday: "long",
        year: "numeric",
        month:"short",
        day:"numeric",
        hour:"2-digit",
        minute:"2-digit"
    },
    /**
     * Init function to start javascript App
     */
    init : function() {
        element = document.getElementById("content");
        element.scrollTop = element.scrollHeight;
        socket = new WebSocket("ws://192.168.179.129:12345/chat");
        this.messageHandling(socket);
        document.getElementById('input-text-chat').addEventListener('keyup', function(event){
            event.preventDefault();
            if(event.keyCode === 13) {
                ChatApp.sendText();
            }
        })
    },
    /**
     * Sets action of websocket onMessage
     */
    messageHandling : function (socket) {
        socket.onmessage = function(msg) {
            message = JSON.parse(msg.data);
            node = document.createElement('div');
            node.setAttribute('class','col-md-12 message-box');
            ChatApp.innerHTMLFill(node, message.name, message.date, message.text);
            element = document.getElementById("content");
            element.appendChild(node);
            element.scrollTop = element.scrollHeight;
        }; 
    },
    /**
     * Fills node with HTML for Message content
     */
    innerHTMLFill : function(htmlNode, name, date, text) {
        htmlNode.innerHTML =  
                "<div class = \"message-header\">"+
                "<p class = \"time-stamp\">"+date+"</p>"+
                "<p class = \"user-name\">"+name+"</p\>"+
                "</div>"+
                "<div class = \"message-content\">"+
                "    <p class = \"message\">"+text+"</p>"+
                "</div>";
    },
    /**
     * send Text to websocket and a request for databse saving
     */
    sendText : function() {
        message = this.makeMessage();
        if(message.text == "\n") {
            document.getElementById('input-text-chat').value = "";
            return;
        }
        socket.send(JSON.stringify(message));
        document.getElementById('input-text-chat').value = "";
        this.sendRequest(message);
     },
     /**
      * send request
      */
      sendRequest : function(message) {
        token = document.getElementById('csrf-token').value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST",'',true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', token);
        xhr.send(JSON.stringify(message));
      },
     /**
      * Make message object
      */
     makeMessage : function() {
         return message = {
            type: "message",
            name: document.getElementById("name").value, 
            text: document.getElementById('input-text-chat').value,
            id: document.getElementById("id").value,
            date: new Intl.DateTimeFormat("en-US",this.options).format(Date.now())
        };
     },
}
ChatApp.init();
