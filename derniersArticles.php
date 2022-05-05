<?php
/*
  Plugin Name: Derniers Articles
  Plugin URI: https://tcgrandchamp.fr
  Description: Ce plugin permet d'alimenter la page d'accueil automatiquement avec les 5 derniers Articles mis en lignes
  Version: 0.1
  Author: TC-Grandchamp
*/
  require_once plugin_dir_path(__FILE__).'includes/affichageAccueil.php';

  defined('ABSPATH') or die('Hey, you can\t access this file, you silly humain!!!');

  class DerniesArticlesPlugin
  {
    //fonction générale de la classe
    function __construct()
    {
    //règles à appliquer de manières générale
    }
    function register()
      {
        add_action('wp_enqueue_scripts', array(
            $this,
            'enqueueStyle'
        ));
      
      }
      function enqueueStyle()
      {
        //mise en attente des scripts exemple css js etc pour la lecture
        wp_enqueue_style( 'derniersArticles', plugin_dir_url(__FILE__) . '/styles/derniersArticles.css',array(), time(), false);
      }

      function dequeueStyle()
      {
        //mise en attente des scripts exemple css js etc pour la lecture
        wp_dequeue_style( 'derniersArticles');
      }
    function activationPlugin()
    {

    }
    function desactivationPlugin()
    {

    }
}
    // Verifier que la classe existe 
    if (class_exists('DerniesArticlesPlugin')) {
      $DerniesArticlesPlugin = new DerniesArticlesPlugin();
      $DerniesArticlesPlugin->register();
    }

    // Appel de la fonction d'activationPlugin et réalisation des actions associées
    register_activation_hook(__FILE__, array(
      $DerniesArticlesPlugin,
      'activationPlugin'
    ));
  
    // Appel de la fonction de desactivationPlugin et réalisation des actions associées
    register_deactivation_hook(__FILE__, array(
      $DerniesArticlesPlugin,
      'desactivationPlugin'
    ));
  
  ?>