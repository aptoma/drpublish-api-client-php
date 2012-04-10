<?php
/**
 * DrPublishApiClientSearchList.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientSearchList is an extension of DrPublishApiClientList with additional metadata for search results
 *
 * Available parameters are:
 * - string $query The query for the search
 * - int $offset The offset given for the search
 * - int $limit The limit given for the search
 * - int $hits The number of returned hits
 * - int $total The total number of hits
 * - float $time The time the search took in seconds
 *
 * __get, __set, __isset and __unset are overloaded so that access can be done through attributes
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @author     jon@aptoma.no
 *
 * @see DrPublishApiClientList
 */
class DrPublishApiClientSearchList extends DrPublishApiClientList {
  protected $_meta = array (
    'query' => '',
  	'total' => 0,
  	'hits' => 0,
  	'offset' => 0,
  	'limit' => 0,
  	'time' => 0.000
  );
  
  /**
   * Store all the meta data from a search in one go
   * @param string $query The query for the search
   * @param int $offset The offset given for the search
   * @param int $limit The limit given for the search
   * @param int $hits The number of returned hits
   * @param int $total The total number of hits
   * @param float $time The time the search took in seconds
   */
  protected function storeMeta ( $query, $offset, $limit, $hits, $total, $time ) {
    $this -> _meta = array (
      'query' => $query,
    	'hits' => $hits,
    	'total' => $total,
    	'start' => $offset,
    	'limit' => $limit,
    	'time' => $time
    );
  }
  
  /**
   * Trigger an E_USER_NOTICE if an inaccessible field is being accessed
   * @param string $name Name of field
   * @param string $access Name of access method
   */
  protected function _trigger_inaccessible ( $name, $access ) {
    $trace = debug_backtrace();
    trigger_error ( sprintf (
    	'Undefined property via %s(): %s in %s on line%d',
    	$access,
    	$name,
    	$trace[0]['file'],
    	$trace[1]['line']
    ), E_USER_NOTICE );
  }
  
  /**
  * @Override
  */
  public function __set ( $name, $value ) {
    if ( array_key_exists ( $name, $this -> _meta ) ) {
      $this -> _meta[$name] = $value;
    } else {
      $this -> _trigger_inaccessible ( $name, '__set' );
    }
  }

  /**
  * @Override
  */
  public function __get($name) {
    if ( array_key_exists ( $name, $this -> _meta ) ) {
      return $this -> _meta[$name];
    }
    
    $this -> _trigger_inaccessible ( $name, '__get' );
    
    return null;
  }

  /**
   * @Override
   */
  public function __isset ( $name ) {
    return array_key_exists ( $name, $this -> _meta );
  }

  /**
  * @Override
  */
  public function __unset ( $name ) {
    unset ( $this -> _meta[$name] );
  }
}