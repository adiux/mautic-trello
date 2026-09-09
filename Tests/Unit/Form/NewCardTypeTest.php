<?php

declare(strict_types=1);

namespace MauticPlugin\AivieTrelloBundle\Tests\Unit\Form;

use MauticPlugin\AivieTrelloBundle\Form\NewCardType;
use MauticPlugin\AivieTrelloBundle\Openapi\lib\Model\NewCard;
use MauticPlugin\AivieTrelloBundle\Openapi\lib\Model\TrelloList;
use MauticPlugin\AivieTrelloBundle\Service\TrelloApiService;
use Psr\Log\NullLogger;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class NewCardTypeTest extends TypeTestCase
{
    protected function getExtensions(): array
    {
        $apiService = $this->createMock(TrelloApiService::class);
        $apiService->method('getListsOnBoard')->willReturn([
            new TrelloList(['id' => 'list123', 'name' => 'To do']),
        ]);

        return [new PreloadedExtension([new NewCardType($apiService, new NullLogger())], [])];
    }

    /**
     * @dataProvider dueDateProvider
     */
    public function testSubmitDueDate(string $submittedDue, ?string $expectedDue): void
    {
        $card = new NewCard([
            'name'      => 'Test contact',
            'due'       => new \DateTime('+1 week'),
            'contactId' => 1,
        ]);
        $form = $this->factory->create(NewCardType::class, $card);

        $this->assertFalse($form->get('due')->isRequired());
        $this->assertFalse($form->createView()['due']->vars['required']);

        $form->submit([
            'name'      => 'Test contact',
            'desc'      => 'Contact description',
            'idList'    => 'list123',
            'due'       => $submittedDue,
            'urlSource' => 'https://example.com/s/contacts/view/1',
            'contactId' => '1',
        ]);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());
        $this->assertTrue($card->valid());

        $payload = json_decode((string) $card, true, 512, JSON_THROW_ON_ERROR);
        if (null === $expectedDue) {
            $this->assertArrayNotHasKey('due', $payload);
            $this->assertNull($card->getDue());
        } else {
            $expectedDate = new \DateTime($expectedDue);
            $this->assertSame($expectedDate->format(\DateTime::ATOM), $payload['due']);
            $this->assertEquals($expectedDate, $card->getDue());
        }
    }

    public static function dueDateProvider(): iterable
    {
        yield 'no due date' => ['', null];
        yield 'with due date' => ['2026-09-21T10:30', '2026-09-21T10:30:00'];
    }
}
