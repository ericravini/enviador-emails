<?php
  include('libs/smarty/libs/Smarty.class.php');

  use Smarty\Smarty;
  
  $smarty = new Smarty();
  // usado para que todas as strings passadas pelo smarty sejam consideradas "seguras" pro html. preciso dar uma olhada a mais nisso.
  $smarty->setEscapeHtml(true); 
