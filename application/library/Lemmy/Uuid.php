<?php
/**
 * Lemmy_Uuid
 *
 * Ein Universally Unique Identifier (UUID) ist ein Standard für Identifikatoren,
 * der in der Softwareentwicklung verwendet wird.
 * Er ist von der Open Software Foundation (OSF) als Teil des Distributed Computing Environment (DCE) standardisiert.
 * Die Absicht hinter UUIDs ist, Informationen in verteilten Systemen ohne großartige zentrale Koordination eindeutig kennzeichnen zu können.
 *
 * Obwohl die Eindeutigkeit für generierte UUID nicht garantiert ist,
 * ist die Gesamtzahl der zufällig generierten UUIDs (Version 4) mit 2^122 = 5,3169 * 10^36 so groß,
 * dass die Wahrscheinlichkeit der Erzeugung zweier gleicher UUIDs sehr klein ist.
 * Daher können UUIDs beliebig ohne zentrales Kontrollorgan erzeugt und zur Kennzeichnung eingesetzt werden,
 * ohne relevante Gefahr zu laufen, dass dieselbe UUID für etwas anderes verwendet wird.
 * Mit UUID markierte Informationen können somit später in einer einzigen Datenbank zusammengeführt werden,
 * ohne Bezeichnerkonflikte auflösen zu müssen.
 *
 * @package Lemmy
 * @author  Jan Thoennessen <jan.thoennessen@googlemail.com>
 */
class Lemmy_Uuid {

    /**
     * erstellt eine 36 stellige uuid nach dce standard
     *
     * @return string
     */
    public static function get() {
        mt_srand(intval(microtime(true) * 1000));

        $b = md5(uniqid(mt_rand(), true), true);
        $b[6] = chr((ord($b[6]) & 0x0F) | 0x40);
        $b[8] = chr((ord($b[8]) & 0x3F) | 0x80);

        return implode('-', unpack('H8a/H4b/H4c/H4d/H12e', $b));
    }
}