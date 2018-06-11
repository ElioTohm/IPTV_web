<template>
    <div>
        <div class="chat-box">
			<div class="chat-head">
				<h2>Chat Box</h2>
				<img src="https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_down-16.png" title="Expand Arrow" width="16">
			</div>
			<div class="chat-body">
				<div class="msg-insert">
                    <div class="msg-send"> Send message </div>
                    <div class="msg-receive"> Received message </div>
                </div>
				<div class="chat-text">
					<textarea placeholder="Send"></textarea>
				</div>
			</div>
		</div>
    </div>
</template>
<script>
export default {
    methods: {
        showhide() {
            var arrow = $('.chat-head img');
            var textarea = $('.chat-text textarea');

            arrow.on('click', function(){
                var src = arrow.attr('src');

                $('.chat-body').slideToggle('fast');
                if(src == 'https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_down-16.png'){
                    arrow.attr('src', 'https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_up-16.png');
                }
                else{
                    arrow.attr('src', 'https://maxcdn.icons8.com/windows10/PNG/16/Arrows/angle_down-16.png');
                }
            });

            textarea.keypress(function(event) {
                var $this = $(this);

                if(event.keyCode == 13){
                    var msg = $this.val();
                    $this.val('');
                    $('.msg-insert').append("<div class='msg-send'>"+msg+"</div>");
                    }
            });
        }
    }
}
</script>