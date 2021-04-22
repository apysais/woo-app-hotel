<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wa_verbage( $key = '', $lang = 'DANSK' ) {
  $verbage = [
    'dashboard' => [
      'ENG' => 'Kitchen',
      'DANSK' => 'Køkken'
    ],
    'local' => [
      'ENG' => 'Processing',
      'DANSK' => 'Processing'
    ],
    'ready' => [
      'ENG' => 'Ready',
      'DANSK' => 'Ready'
    ],
    'done' => [
      'ENG' => 'Done',
      'DANSK' => 'Fakturering'
    ],
    'complete' => [
      'ENG' => 'Complete',
      'DANSK' => 'Afsluttet'
    ],
    'released_orders' => [
      'ENG' => 'Processed Orders',
      'DANSK' => 'Behandler'
    ],
    'ready_orders' => [
      'ENG' => 'Ready Orders',
      'DANSK' => 'Klarmeldt'
    ],
    'view_details' => [
      'ENG' => 'View Details',
      'DANSK' => 'Detaljer'
    ],
    'items' => [
      'ENG' => 'Items',
      'DANSK' => 'Antal'
    ],
    'edit' => [
      'ENG' => 'Edit',
      'DANSK' => 'Rediger'
    ],
    'placement' => [
      'ENG' => 'Placement',
      'DANSK' => 'Placering'
    ],
    'customer_info' => [
      'ENG' => 'Customer Info',
      'DANSK' => 'Kundeinfo'
    ],
    'delivery_address' => [
      'ENG' => 'Delivery Address',
      'DANSK' => 'Leveringsadresse'
    ],
    'notes_from_customer' => [
      'ENG' => 'Notes from customer',
      'DANSK' => 'Besked fra kunde'
    ],
    'new' => [
      'ENG' => 'New',
      'DANSK' => 'Ny ordre'
    ],
    'processing' => [
      'ENG' => 'Processing',
      'DANSK' => 'Igangsat'
    ],
    'cancel' => [
      'ENG' => 'Cancel',
      'DANSK' => 'Annuller'
    ],
    'finish_order' => [
      'ENG' => 'Finish Order',
      'DANSK' => 'Afslut ordre'
    ],
    'search_order' => [
      'ENG' => 'Search Order',
      'DANSK' => 'Søg ordre'
    ],
    'search' => [
      'ENG' => 'Search',
      'DANSK' => 'Søg'
    ],
    'orders' => [
      'ENG' => 'Orders',
      'DANSK' => 'Ordre'
    ],
    'order' => [
      'ENG' => 'Order',
      'DANSK' => 'Ordre'
    ],
    'new_order' => [
      'ENG' => 'New Order',
      'DANSK' => 'Pakkeri'
    ],
    'new_orders' => [
      'ENG' => 'New Orders',
      'DANSK' => 'Nye ordre'
    ],
    'comment_to_warehouse' => [
      'ENG' => 'Comment to Kitchen',
      'DANSK' => 'Besked til Kitchen'
    ],
    'mark_as_important' => [
      'ENG' => 'Mark as Important',
      'DANSK' => 'Vigtig ordre'
    ],
    'released' => [
      'ENG' => 'Released',
      'DANSK' => 'Køkken'
    ],
    'customer' => [
      'ENG' => 'Customer',
      'DANSK' => 'Kunde'
    ],
    'ordered_on' => [
      'ENG' => 'Ordered On',
      'DANSK' => 'Bestilt d'
    ],
    'order_items' => [
      'ENG' => 'Order Items',
      'DANSK' => 'Antal'
    ],
    'notes' => [
      'ENG' => 'Notes',
      'DANSK' => 'Noter'
    ],
    'search_results' => [
      'ENG' => 'Search Results',
      'DANSK' => 'Søgeresultater'
    ],
    'print' => [
      'ENG' => 'Print',
      'DANSK' => 'Print'
    ],
  ];
  if ( defined('WA_LANG') ) {
    return isset($verbage[$key][WA_LANG]) ? $verbage[$key][WA_LANG] : $key;
  } else {
    return isset($verbage[$key][$lang]) ? $verbage[$key][$lang] : $key;
  }
}
