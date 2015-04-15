<?php

namespace Mobly\Async\Test\Fork;

use Mobly\Async\Fork\Dispatcher;
use Mobly\Async\Fork\Process;
use Mobly\Async\Fork\ResultCollection;
use Mobly\Async\Fork\ProcessCollection;
use Mobly\Async\Fork\Result;

/**
 *
 * @package Mobly\Async\Test\Fork
 * @author  Arthur Guimaraes
 */
class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testProccessTasks()
    {
        $data = [
            [
                'class' => '\\Mobly\\Async\\Test\\Task\\Example',
                'data' => [
                    'qty' => 3,
                ],
            ],
            [
                'class' => '\\Mobly\\Async\\Test\\Task\\Example',
                'data' => [
                    'qty' => 4,
                ],
            ],
        ];

        $resultCollection = $this->getResultCollectionByData($data);

        $this->assertEquals(2, $resultCollection->count());

        foreach ($resultCollection as $result) {
            $this->assertInstanceOf('\\Mobly\\Async\\Fork\\Result', $result);
            $this->assertInstanceOf('\\Mobly\\Async\\Fork\\Process', $result->getProcess());
            $processData = $result->getProcess()->getData();
            $quantity = $processData['qty'];
            $this->assertTrue(!empty($quantity));
            $this->assertTrue($result->getErrorMessage() == null);
            $this->assertTrue($result->isSuccessful());
            $this->assertEquals($quantity * 2, $result->getData());
        }
    }

    public function testProccessTasksWithParameterError()
    {
        $data = [
            [
                'class' => '\\Mobly\\Async\\Test\\Task\\Example',
                'data' => [],
            ],
            [
                'class' => '\\Mobly\\Async\\Test\\Task\\Example',
                'data' => [],
            ],
        ];

        $resultCollection = $this->getResultCollectionByData($data);

        $this->assertEquals(2, $resultCollection->count());

        foreach ($resultCollection as $result) {
            $this->assertInstanceOf('\\Mobly\\Async\\Fork\\Result', $result);
            $this->assertInstanceOf('\\Mobly\\Async\\Fork\\Process', $result->getProcess());
            $this->assertFalse($result->isSuccessful());
            $this->assertEquals('Provide a quantity', $result->getErrorMessage());
        }
    }
    
    public function testProccessTasksWithClassError()
    {
        $data = [
            [
                'class' => 'Wova',
                'data' => [],
            ],
        ];

        $resultCollection = $this->getResultCollectionByData($data);

        $this->assertEquals(1, $resultCollection->count());

        foreach ($resultCollection as $result) {
            $this->assertInstanceOf('\\Mobly\\Async\\Fork\\Result', $result);
            $this->assertInstanceOf('\\Mobly\\Async\\Fork\\Process', $result->getProcess());
            $this->assertFalse($result->isSuccessful());
            $this->assertEquals('Invalid class provided: "Wova"', $result->getErrorMessage());
        }
    }

    public function getResultCollectionByData($data)
    {
        $processCollection = new ProcessCollection();

        foreach ($data as $input) {
            $processEntity = new Process(
                $input['class'],
                $input['data']
            );

            $processCollection->add($processEntity);
        }


        $dispatcher = new Dispatcher($processCollection);
        return $dispatcher->getResultCollection();

    }
}

