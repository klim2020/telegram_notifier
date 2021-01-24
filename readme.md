# Opencart bot module for  telegram chat notifications opencart 2.0.x - 2.2.x

## How to use 

-install

-go to (botfather and register a bot)

-add your bot to your group

-send a message in  your group so the bot can 'see' your message

-check getUpdates(using this guide) method to see your chat id

-create new bot in admin panel()

-anywhere in your controller or model add:

`   $this->load->model('tool/telegram');//inits telegram model
`   $this->model_tool_telegram->sendMessageByName('bot_name_from_admin_panel',$text);//sends a message to your channel
