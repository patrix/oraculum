<?php
/**
 *
 *    @filesource     $HeadURL: $
 *    @category       Framework
 *    @package        oraculum
 *    @author         Patrick Kaminski <patrick@sbsti.com.br>
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPL3)
 *    @link           http://code.google.com/p/oraculum-php/ Oraculum Framework
 *    @copyright      Copyright 2009, Patrick Kaminski.
 *    @since          Oraculum Framework v0.1a
 *    @version        $Revision: $
 *    @modifiedby     $LastChangedBy:  $
 *    @lastmodified   $Date: 2009-09-01 23:27:59 -0300 (Ter, 01 Set 2009) $
 *
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPLv3. For more information, see
 * <http://www.opensource.org/licenses/lgpl-3.0.html>
 *
 */
  $include=include("./apps/default/config/init.php");
  if ($include) {
      $app=new Controller;
  } else {
    die("Projeto n&atilde;o encontrado!");
  }
