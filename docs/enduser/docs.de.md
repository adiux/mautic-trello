## Mautic - Trello Plugin

Dieses Plugin erstellt Trello-Karten basierend auf einem Mautic Kontakt.

## Anforderungen

- Mautic V3.0.2
- Trello

## Autorisieren Sie das Plugin

**Achtung:**
Für den Autorisierungsprozess des Plugin empfehlen wir, einen separaten Trello-Benutzer als Ihren normalen Benutzer zu verwenden. Jeder mit Zugang zu Ihrer Mautic-Instanz wird in der Lage sein, die Namen aller Trello Boards und Listen zu sehen, auf die dieser Trello-Benutzer Zugriff hat. Außerdem können über Mautic neue Karten in diesen Trello Boards und Listen erstellt werden. Die einzelnen Trello-Karten können allerdings nicht über Mautic eingesehen werden.

1. Öffnen sie die Trello-Plugin-Einstellungen (Einstellungen > Plugins)\
   <img src="media/trello-plugin-settings-en.png" alt="Trello Plugin Settings" width="400"/>
2. Öffnen sie [https://trello.com/app-key][trello app key] in einem separaten Fenster.\
   <img src="media/trello-app-key-en.png" alt="Get auth keys on Trello" width="400"/>
3. Kopieren sie den angezeigten Schlüssel (Key) und fügen Sie ihn zu den Plugin-Einstellungen hinzu.
4. Klicken Sie auf "Token" generieren unter [https://trello.com/app-key][trello app key]
5. Folgen Sie dem Autorisierungsprozess bei Trello
6. Kopieren Sie das angezeigte Token und fügen Sie es zu den Einstellungen des Trello-Plugins hinzu

Vergessen Sie nicht, *Veröffentlicht* auf *Ja* umzuschalten und die Konfiguration zu speichern.

## Konfigurieren sie das Plugin

Gehen sie zu Ihren Einstellungen und stellen Sie Ihr bevorzugtes Board ein. Derzeit ist das Plugin auf die Verwendung mit nur einem Trello-Board limitiert.

## Trello Karte erstellen

1. Öffnen sie den Kontakt in der Detailansicht. 
2. Klicken sie auf den kleinen Pfeil um die erweiterten Aktionen anzuzeigen.\
<img src="media/trello-plugin-add-card.png" alt="Get auth keys on Trello" width="400"/>
3. Klicken sie auf "Trello Karte erstellen".
4. Geben sie alle gewünschten Informationen ein und klicken Sie auf "Speichern".  
<img src="media/trello-plugin-add-card-info-en.png" alt="Add Trello card information" width="400"/>

**Hinweis:**
Aktuell können nur Listen aus einem Board gewählt werden. Das Board kann über Einstellungen > Konfiguration > Trello geändert werden.

[trello app key]: <https://trello.com/app-key>