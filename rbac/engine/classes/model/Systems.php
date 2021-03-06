<?php
/**
 * Systems.php
 * @package  rbac-classes-model
 * 
 * ProcessMaker Open Source Edition
 * Copyright (C) 2004 - 2011 Colosa Inc.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * For more information, contact Colosa Inc, 2566 Le Jeune Rd., 
 * Coral Gables, FL, 33134, USA, or email info@colosa.com.
 * 
 */
  /**
  * @access public
  */
require_once 'classes/model/om/BaseSystems.php';


/**
 * Skeleton subclass for representing a row from the 'SYSTEMS' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package  rbac-classes-model
 */
class Systems extends BaseSystems {

  /**
   * Load the Application row specified in [app_id] column value.
   * 
   * param      string $AppUid   the uid of the application 
   * return     array  $Fields   the fields
   * Function Load
   * access public
   */
  
  function Load ( $SysUid ) {
    $con = Propel::getConnection(SystemsPeer::DATABASE_NAME);
    try {
      $oSystem = SystemsPeer::retrieveByPk( $SysUid );
      if (is_object($oSystem) && get_class ($oSystem) == 'Systems' ) {
        $aFields = $oSystem->toArray(BasePeer::TYPE_FIELDNAME);
        $this->fromArray ($aFields, BasePeer::TYPE_FIELDNAME );
        return $aFields;
      }
      else {
        throw( new Exception( "This Systems row doesn't exist!" ));
      }
    }
    catch (Exception $oError) {
      throw($oError);
    }
  }

  function LoadByCode ( $SysUid ) {
    $con = Propel::getConnection(SystemsPeer::DATABASE_NAME);
    try {
      $c = new Criteria( 'rbac' );
      $c->add ( SystemsPeer::SYS_CODE, $SysUid );
      $rs = SystemsPeer::doSelect( $c );
      if ( is_array($rs) && isset( $rs[0] ) && is_object($rs[0]) && get_class ( $rs[0] ) == 'Systems' ) {
        $aFields = $rs[0]->toArray(BasePeer::TYPE_FIELDNAME);
        $this->fromArray ($aFields, BasePeer::TYPE_FIELDNAME );
        return $aFields;
      }
      else {
        throw( new Exception( "This Systems row doesn't exist!" ));
      }
    }
    catch (Exception $oError) {
      throw($oError);
    }
  }

  function create ( $aData ) {
    $con = Propel::getConnection(SystemsPeer::DATABASE_NAME);
    try {
      $SysUid = $aData['SYS_CODE'];
      $c = new Criteria( 'rbac' );
      $c->add ( SystemsPeer::SYS_CODE, $SysUid );
      $rs = SystemsPeer::doSelect( $c );
      $exists = ( is_array($rs) && isset( $rs[0] ) && is_object($rs[0]) && get_class ( $rs[0] ) == 'Systems' );
      
      if ( $exists ) return; 

      $aData['SYS_UID']         = G::generateUniqueId();
      $aData['SYS_CREATE_DATE'] = date ('Y-m-d H:i:s');
      $aData['SYS_UPDATE_DATE'] = date ('Y-m-d H:i:s');
      $aData['SYS_STATUS']      = '1';

      $this->fromArray($aData, BasePeer::TYPE_FIELDNAME);
      if ($this->validate()) {
          $result = $this->save();
      } 
      else {
        $e = new Exception("Failed Validation in class " . get_class($this) . ".");
        $e->aValidationFailures = $this->getValidationFailures();
        throw ($e);
      }
      $con->commit();
      return $result;
    }
    catch (exception $e) {
      $con->rollback();
      throw ($e);
    }
  }

} // Systems
