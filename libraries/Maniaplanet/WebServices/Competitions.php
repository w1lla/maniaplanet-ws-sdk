<?php
/**
 * @copyright   Copyright (c) 2009-2012 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 9143 $:
 * @author      $Author: gwendal $:
 * @date        $Date: 2012-12-18 15:10:25 +0100 (mar., 18 déc. 2012) $:
 */

namespace Maniaplanet\WebServices;

class Competitions extends HTTPClient
{
	const REGISTRATION_MODE_OPEN = 1;
	const REGISTRATION_MODE_OPEN_VALIDATION_NEEDED = 2;
	const REGISTRATION_MODE_CLOSED = 3;

	/**
	 * return the Map pool of the competition
	 * @param int $id Id of the competition
	 * @return object
	 * @throws Exception
	 */
	function getMapPool($competitionId)
	{
		if(!$competitionId)
		{
			throw new Exception('Invalid competitionId');
		}

		return $this->execute('GET', '/competitions/%d/maps/', array($competitionId));
	}

	function getInvitationKey($competitionId, $offset = 0, $length = 20)
	{
		if(!$competitionId)
		{
			throw new Exception('Invalid competitionId');
		}
		return $this->execute('GET', '/competitions/%d/keys/', array($competitionId));
	}

	function inviteTeam($competitionId, $teamId)
	{
		if(!$competitionId)
		{
			throw new Exception('Invalid competitionId');
		}
		if(!$teamId)
		{
			throw new Exception('Invalid teamId');
		}

		return $this->execute('POST', '/competitions/%d/invite/', array($competitionId, array('teamId' => $teamId)));
	}

	function create($name, $titleIdString, $isLan, $registrationMode = self::REGISTRATION_MODE_OPEN)
	{
		if(!$name)
		{
			throw new Exception('Invalid name');
		}
		if(!$titleIdString)
		{
			throw new Exception;
		}

		return $this->execute('POST', '/competitions/',
				array(array(
					'name' => $name,
					'titleId' => $titleIdString,
					'lan' => $isLan,
					'registrationMode' => $registrationMode
				)));
	}
	
	function update($id, $name, $titleIdString, $isLan, $registrationMode = self::REGISTRATION_MODE_OPEN,
			$registrationStartDate = null, $registrationEndDate = null, $startDate = null, $endDate = null,
			$minOpponents = 8, $maxOpponents = 16, $visibility = 0, $registrationCost = 0)
	{
		if(!$name)
		{
			throw new Exception('Invalid name');
		}
		if(!$id)
		{
			throw new Exception;
		}
		if(!$titleIdString)
		{
			throw new Exception;
		}

		return $this->execute('PUT', '/competitions/%d/',
				array($id, array(
					'id' => $id,
					'name' => $name,
					'titleId' => $titleIdString,
					'lan' => $isLan,
					'registrationMode' => $registrationMode,
					'registrationStartDate' => $registrationStartDate,
					'registrationEndDate' => $registrationEndDate,
					'startDate' => $startDate,
					'endDate' => $endDate,
					'minOpponents' => $minOpponents,
					'maxOpponents' => $maxOpponents,
					'visibility' => $visibility,
					'registrationCost' => $registrationCost,
				)));
	}

	/**
	 * Register final results of your competition
	 * @param int $competitionId
	 * @param array $results results should be an array with numeric keys from 1 to n, with the team ids as value
	 */
	function registerResults($competitionId, array $results)
	{
		if(!$competitionId)
		{
			throw new Exception;
		}
		if(!$results)
		{
			throw new Exception;
		}
		return $this->execute('POST', '/competitions/%d/results/', array($competitionId, array($results)));
	}

}

?>