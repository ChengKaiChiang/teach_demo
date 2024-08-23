<?php

namespace App\Sms\Drivers;

use App\Sms\SenderInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Testing\Fakes\Fake;
use PHPUnit\Framework\Assert as PHPUnit;
use RuntimeException;

/**
 * 單元測試專用
 */
class FakeSender implements SenderInterface, Fake
{
    private array $sentMessage = [];

    public function __construct()
    {
        if (config('app.env') !== 'testing') {
            throw new RuntimeException('SmsFake cannot use on non-testing environment.');
        }
    }

    public function send(string $cellphone, View $view): void
    {
        $this->sentMessage[$cellphone][] = trim($view->render());
    }

    /**
     * @param string $cellphone
     * @param callable|null $callback
     * @return void
     */
    public function assertSent(string $cellphone, ?callable $callback = null): void
    {
        PHPUnit::assertTrue(
            $this->sent($cellphone, $callback)->count() > 0,
            "The expected [$cellphone] cellphone was not sent.",
        );
    }

    /**
     * @param string $cellphone
     * @param callable|null $callback
     * @return void
     */
    public function assertNotSent(string $cellphone, ?callable $callback = null): void
    {
        PHPUnit::assertCount(
            0,
            $this->sent($cellphone, $callback),
            "The unexpected [{$cellphone}] cellphone was sent message.",
        );
    }

    /**
     * Assert that no message were sent.
     *
     * @return void
     */
    public function assertNothingSent(): void
    {
        $count = count(Arr::flatten($this->sentMessage));

        PHPUnit::assertSame(
            0,
            $count,
            "$count unexpected message were sent.",
        );
    }

    /**
     * Assert that something message were sent.
     *
     * @return void
     */
    public function assertSomethingSent(): void
    {
        $count = count(Arr::flatten($this->sentMessage));

        PHPUnit::assertTrue(
            $count > 0,
            "$count unexpected message were not sent.",
        );
    }

    /**
     * @param string $cellphone
     * @param callable|null $callback
     * @return Collection
     */
    public function sent(string $cellphone, callable $callback = null): Collection
    {
        if (!$this->hasSent($cellphone)) {
            return Collection::make();
        }

        $callback = $callback ?: fn() => true;

        return collect($this->sentMessage[$cellphone])->filter(
            fn(string $content) => $callback($content),
        );
    }

    /**
     * Determine if the given cellphone has been sent.
     *
     * @param string $cellphone
     * @return bool
     */
    public function hasSent(string $cellphone): bool
    {
        return isset($this->sentMessage[$cellphone]) && !empty($this->sentMessage[$cellphone]);
    }

    public function dump(): void
    {
        dump($this->sentMessage);
    }
}
