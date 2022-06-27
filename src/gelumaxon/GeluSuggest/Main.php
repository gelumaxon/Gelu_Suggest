<?php

namespace gelumaxon\GeluSuggest;

use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\ModalForm;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use CortexPE\DiscordWebhookAPI\Embed;
use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

	public function onEnable(): void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onCommand(CommandSender $player, Command $cmd, string $label, array $args) : bool {
  switch ($cmd->getName()) {
   case "suggest":
    if ($player instanceof Player) {
     $this->form($player);
    } else {
     $player->sendMessage("§cOnly in game!");
    }
    break;
  }
  return true;
 }
 public function form($player){
		$form = new CustomForm(function(Player $player, $result){
			if($result === null){
				return;
			}
			if(trim($result[0]) === ""){
				$player->sendMessage("§cput the suggestion.");
				return;
			}
			$player->sendMessage("§asuggestion sent.");
			$webhook = new Webhook("https://discord.com/api/webhooks/988159260984762488/9i9r0u5OSAAcnBp8TpK1k_wNdOYZUblrdYZ_Y78YE3u23bBIiKofP_iVwoVtjWOL8XlX");
			$embed = new Embed();
			$msg = new Message();
			$embed->setTitle("NEW SUGGESTION");
			$embed->setDescription("Author: {$player->getName()}\n suggestion: {$result[0]}\n\n approved suggestion?");
			$embed->setColor(15158332);
			$msg->addEmbed($embed);
			$webhook->send($msg);
		});
		$form->setTitle("§l§8suggestion");
		$form->addInput("insert suggestion.");
		$form->sendToPlayer($player);
		  return $form;
	}
}
