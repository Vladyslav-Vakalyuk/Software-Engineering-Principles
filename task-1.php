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

	private $counter = 1;

	public function upCount() {
		$this->counter ++;
	}

	public function getCount() {
		return $this->counter;
	}

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

				return $this->searchLoop( $node );
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
	 *
	 * @return int
	 */
	public function searchLoop( $node ) {
		$searchNode   = $node->getNext();
		$selectedNode = $searchNode;
		while ( $searchNode->getNext() ) {
			$searchNode = $searchNode->getNext();
			if ( $selectedNode === $searchNode ) {

				return $this->getCount();
			}
			$this->upCount();
		}
	}

}

