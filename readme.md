# Opencart bot module for  telegram chat notifications opencart 2.0.x - 2.2.x

## How to use 

-install module

-go to ([Botfather](https://telegram.me//botfather "@botfather") and register a bot)

-in Telegram add your bot to your group 

![img1](https://image.prntscr.com/image/0VU1klGhSdacgS5-T_xIMg.png)


-send a message in  your group with your bot so the bot can 'see' your message

![img2](https://image.prntscr.com/image/4poPwqL4T4C2jUNH9tg7FA.png)

-check getUpdates(using this guide) method to see your chat id

![img3](https://image.prntscr.com/image/LW3E_G9iRUiJvbhqkWOWVQ.png)

-create new bot in admin panel

![img4](https://image.prntscr.com/image/4DA4JuMRRK_PCyOELTNHJQ.png)

-anywhere in your controller or model add:

`   $this->load->model('tool/telegram');//inits telegram model`
`   $this->model_tool_telegram->sendMessageByName('bot_name_from_admin_panel',$text);//sends a message to your channel`
