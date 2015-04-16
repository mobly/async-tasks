<?php

namespace Mobly\Async\Fork;

use Mobly\Async\Fork\ProcessCollection;
use Mobly\Async\Fork\Process;
use Mobly\Async\Fork\ResultCollection;
use Mobly\Async\Fork\Result;
use QXS\WorkerPool\WorkerPool;
use QXS\WorkerPool\ClosureWorker;

/**
 * Class Dispatcher
 *
 * @package Fork
 * @author  Arthur Guimarães
 */
class Dispatcher
{
    /**
     * @var string
     */
    const INTERNAL_ERROR = 'Internal Error';

    /**
     * @var ProcessCollection
     */
    protected $processCollection;

    /**
     *
     * @param ProcessCollection $proccessCollection
     */
    public function __construct(ProcessCollection $processCollection)
    {
        $this->processCollection = $processCollection;
    }

    /**
     *
     * @return ResultCollection
     */
    public function getResultCollection()
    {
        $pool = new WorkerPool();
        $pool->setWorkerPoolSize($this->processCollection->count())
            ->create(
                new ClosureWorker(
                    function (Process $process) {
                        $result = new Result();
                        $result->setProcess($process);

                        try {
                            if (!class_exists($process->getClass())) {
                                throw new \Exception(
                                    sprintf(
                                        'Invalid class provided: "%s"',
                                        $process->getClass()
                                    )
                                );
                            }

                            $class = $process->getClass();
                            $class = new $class();

                            $result->setData($class->process($process->getData()));
                            $result->setSuccessful(true);
                        } catch (\Exception $e) {
                            $result->setErrorMessage($e->getMessage());
                        }

                        return $result;
                    }
                )
            );

        foreach ($this->processCollection as $process) {
            $pool->run($process);
        }

        $pool->waitForAllWorkers();

        $resultCollection = new ResultCollection();

        foreach ($pool as $result) {
            $resultEntity = new Result();

            if (!empty($result['data'])) {
                $resultEntity = $result['data'];
            } elseif (!empty($result['workerException']['message'])) {
                $resultEntity->setErrorMessage($result['workerException']['message']);
            } elseif (!empty($result['poolException']['message'])) {
                $resultEntity->setErrorMessage($result['poolException']['message']);
            } else {
                $resultEntity->setErrorMessage(self::INTERNAL_ERROR);
            }

            $resultCollection->add($resultEntity);
        }
        
        return $resultCollection;
    }
}
