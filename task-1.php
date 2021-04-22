<?php
function loop_size( Node $node ): int {

	$nodeChecker = new NodeChecker();
	$nodeChecker->init( $node );

}

/**
 * Class NodeChecker
 */
class NodeChecker {
	/**
	 * Node.
	 *
	 * @var $node
	 */
	private $node;

	/**
	 * @param $node
	 */
	public function setNode( $node ) {
		$this->node = $node;
	}

	/**
	 * @return mixed
	 */
	public function getNode() {
		return $this->node;
	}

	/**
	 * @return false|int
	 */
	public function init() {
		$node = $this->getNode();
		while ( $node->getNext() ) {
			$currentNode[] = $node;
			$node          = $node->getNext();
			if ( $this->compareCurrentNode( $node, $currentNode ) ) {
				return $this->searchLoop( $node, $currentNode );
			}
		}

		return false;
	}

	/**
	 * compareCurrentNode.
	 *
	 * @param $node
	 * @param $currentNode
	 *
	 * @return bool
	 */
	public function compareCurrentNode( $node, $currentNode ) {
		return in_array( $node, $currentNode, true );
	}

	/**
	 * searchLoop.
	 *
	 * @param $node
	 * @param $currentNode
	 *
	 * @return int
	 */
	public function searchLoop( $node, $currentNode ) {
		$i            = 1;
		$lastkey      = array_key_last( $currentNode );
		$lastNode     = $currentNode[ $lastkey ];
		$searchNode   = $node->getNext();
		$selecterNode = $searchNode;
		while ( $searchNode->getNext() ) {
			$searchNode = $searchNode->getNext();
			if ( $selecterNode === $searchNode ) {

				return $i;
			}
			$i ++;
		}
	}

}

