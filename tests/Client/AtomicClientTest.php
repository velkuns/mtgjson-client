<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MagicLegacy\Component\MtgJson\Test\Client;

use MagicLegacy\Component\MtgJson\Client\AtomicClient;
use MagicLegacy\Component\MtgJson\Entity\CardAtomic;
use MagicLegacy\Component\MtgJson\Exception\MtgJsonComponentException;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Log\NullLogger;

/**
 * Class AtomicClientTest
 */
class AtomicClientTest extends TestCase
{
    /**
     * @return void
     * @throws MtgJsonComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestAllCardsEndpointAndRetrieveAtomicCards(): void
    {
        $allCards = $this->getClient()->getAllCards();

        $this->assertCount(2, $allCards);
        $this->assertInstanceOf(CardAtomic::class, $allCards[0]);
    }

    /**
     * @return void
     * @throws MtgJsonComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestVintageEndpointAndRetrieveAtomicCards(): void
    {
        $allCards = $this->getClient()->getVintageCards();

        $this->assertCount(2, $allCards);
        $this->assertInstanceOf(CardAtomic::class, $allCards[0]);
    }

    /**
     * @return void
     * @throws MtgJsonComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestLegacyEndpointAndRetrieveAtomicCards(): void
    {
        $allCards = $this->getClient()->getLegacyCards();

        $this->assertCount(2, $allCards);
        $this->assertInstanceOf(CardAtomic::class, $allCards[0]);
    }

    /**
     * @return void
     * @throws MtgJsonComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestModernEndpointAndRetrieveAtomicCards(): void
    {
        $allCards = $this->getClient()->getModernCards();

        $this->assertCount(2, $allCards);
        $this->assertInstanceOf(CardAtomic::class, $allCards[0]);
    }

    /**
     * @return void
     * @throws MtgJsonComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestPauperEndpointAndRetrieveAtomicCards(): void
    {
        $allCards = $this->getClient()->getPauperCards();

        $this->assertCount(2, $allCards);
        $this->assertInstanceOf(CardAtomic::class, $allCards[0]);
    }

    /**
     * @return void
     * @throws MtgJsonComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestPioneerEndpointAndRetrieveAtomicCards(): void
    {
        $allCards = $this->getClient()->getPioneerCards();

        $this->assertCount(2, $allCards);
        $this->assertInstanceOf(CardAtomic::class, $allCards[0]);
    }

    /**
     * @return void
     * @throws MtgJsonComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestStandardEndpointAndRetrieveAtomicCards(): void
    {
        $allCards = $this->getClient()->getStandardCards();

        $this->assertCount(2, $allCards);
        $this->assertInstanceOf(CardAtomic::class, $allCards[0]);
    }

    /**
     * @return void
     * @throws MtgJsonComponentException
     * @throws ClientExceptionInterface
     */
    public function testICanRequestAtomicEndpointWithoutCardsAndHaveAnEmptyAtomicCardList(): void
    {
        $allCards = $this->getClient(true)->getStandardCards();

        $this->assertCount(0, $allCards);
    }

    /**
     * @param bool $emptyContent
     * @return AtomicClient
     */
    private function getClient(bool $emptyContent = false): AtomicClient
    {
        $httpFactory = new Psr17Factory();
        $response = $httpFactory->createResponse();
        $response->getBody()->write($this->getJsonResponse($emptyContent));
        $response->getBody()->rewind();

        $httpClientMock = $this->createMock(ClientInterface::class);
        $httpClientMock
            ->method('sendRequest')
            ->willReturn($response)
        ;

        return new AtomicClient($httpClientMock, $httpFactory, $httpFactory, $httpFactory, new NullLogger());
    }

    /**
     * @param bool $emptyContent
     * @return string
     */
    private function getJsonResponse(bool $emptyContent = false): string
    {
        if ($emptyContent) {
            return '{"data": {}}';
        }

        return '{
  "meta": {
    "date": "2020-01-01",
    "version": "1.0.0+20200101"
  },
  "data": {
    "Absorb": [
      {
        "colorIdentity": [
          "U",
          "W"
        ],
        "colors": [
          "U",
          "W"
        ],
        "convertedManaCost": 3.0,
        "edhrecRank": 3170,
        "foreignData": [
          {
            "flavorText": "„Dein fehlgeleiteter Versuch, die Gesetze zu unterlaufen, beweist, dass diese Gesetze dringend notwendig sind.\"",
            "language": "German",
            "name": "Absorbieren",
            "text": "Neutralisiere einen Zauberspruch deiner Wahl. Du erhältst 3 Lebenspunkte dazu.",
            "type": "Spontanzauber"
          },
          {
            "flavorText": "\"En tu intento equivocado de subvertir la ley, explicaste con elocuencia por qué debe existir\".",
            "language": "Spanish",
            "name": "Absorber",
            "text": "Contrarresta el hechizo objetivo. Ganas 3 vidas.",
            "type": "Instantáneo"
          },
          {
            "flavorText": "« Dans votre tentative malavisée de renverser la loi, vous avez expliqué avec éloquence pourquoi elle doit exister. »",
            "language": "French",
            "name": "Absorption",
            "text": "Contrecarrez le sort ciblé. Vous gagnez 3 points de vie.",
            "type": "Éphémère"
          },
          {
            "flavorText": "\"Con il tuo malaccorto tentativo di sovvertire la legge, ne hai dimostrato esaustivamente la necessità.\"",
            "language": "Italian",
            "name": "Assorbire",
            "text": "Neutralizza una magia bersaglio. Guadagni 3 punti vita.",
            "type": "Istantaneo"
          },
          {
            "flavorText": "「法を脅かすという君の誤った試みの中に、法がなくてはならない理由が雄弁に語られている。」",
            "language": "Japanese",
            "name": "吸収",
            "text": "呪文１つを対象とし、それを打ち消す。あなたは３点のライフを得る。",
            "type": "インスタント"
          },
          {
            "flavorText": "\"잘못된 판단에 근거해 법을 전복시키려 한 네 시도가 왜 법이 존재해야만 하는지를 역설해 주었다.\"",
            "language": "Korean",
            "name": "흡수",
            "text": "주문을 목표로 정한다. 그 주문을 무효화한다. 당신은 생명 3점을 얻는다.",
            "type": "순간마법"
          },
          {
            "flavorText": "\"Em sua equivocada tentativa de subverter a lei, você explicou eloquentemente a necessidade da lei.\"",
            "language": "Portuguese (Brazil)",
            "name": "Absorver",
            "text": "Anule a mágica alvo. Você ganha 3 pontos de vida.",
            "type": "Mágica Instantânea"
          },
          {
            "flavorText": "«Своей нелепой попыткой помешать исполнению закона ты лишь красноречиво показал, почему он должен существовать».",
            "language": "Russian",
            "name": "Поглощение",
            "text": "Отмените целевое заклинание. Вы получаете 3 жизни.",
            "type": "Мгновенное заклинание"
          },
          {
            "flavorText": "「在你试图颠覆律法的错误过程中，你已经完美地阐述了律法为何必须存在。」",
            "language": "Chinese Simplified",
            "name": "吸收",
            "text": "反击目标咒语。你获得3点生命。",
            "type": "瞬间"
          },
          {
            "flavorText": "「在你試圖顛覆律法的錯誤過程中，你已經完美地闡述了律法為何必須存在。」",
            "language": "Chinese Traditional",
            "name": "吸收",
            "text": "反擊目標咒語。你獲得3點生命。",
            "type": "瞬間"
          }
        ],
        "identifiers": {
          "scryfallOracleId": "132ca99a-a3c7-4ed6-b4d0-0edcd7140ca2"
        },
        "layout": "normal",
        "legalities": {
          "brawl": "Legal",
          "commander": "Legal",
          "duel": "Legal",
          "historic": "Legal",
          "legacy": "Legal",
          "modern": "Legal",
          "pioneer": "Legal",
          "standard": "Legal",
          "vintage": "Legal"
        },
        "manaCost": "{W}{U}{U}",
        "name": "Absorb",
        "printings": [
          "INV",
          "PRNA",
          "RNA"
        ],
        "purchaseUrls": {
          "cardKingdom": "https://mtgjson.com/links/97df0cbe32ca7578",
          "cardKingdomFoil": "https://mtgjson.com/links/8824adcfb522f4bc",
          "cardmarket": "https://mtgjson.com/links/3a6dcfad03f4e1a7",
          "tcgplayer": "https://mtgjson.com/links/5ea175bf444f70fe"
        },
        "rulings": [
          {
            "date": "2019-01-25",
            "text": "A spell that can’t be countered is a legal target for Absorb. The spell won’t be countered when Absorb resolves, but you’ll still gain 3 life."
          }
        ],
        "subtypes": [],
        "supertypes": [],
        "text": "Counter target spell. You gain 3 life.",
        "type": "Instant",
        "types": [
          "Instant"
        ]
      }
    ],
    "Any Minimal Card": [
      {
        "colorIdentity": [],
        "colors": [],
        "convertedManaCost": 0.0,
        "edhrecRank": 3170,
        "foreignData": [],
        "identifiers": null,
        "layout": "normal",
        "legalities": null,
        "manaCost": "{W}{U}{U}",
        "name": "Absorb",
        "printings": [],
        "purchaseUrls": null,
        "rulings": [],
        "subtypes": [],
        "supertypes": [],
        "text": "Counter target spell. You gain 3 life.",
        "type": "Instant",
        "types": []
      }
    ]
  }
}';
    }
}
