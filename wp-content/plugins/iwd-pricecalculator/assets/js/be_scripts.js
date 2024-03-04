/** */
if(jQuery('.iwd-nav-tab').length > 0) {
    jQuery(document).on('click', '.iwd-nav-tab', function(event) {
        event.preventDefault(); 
        jQuery('.iwd-tab').hide(); 
        jQuery('#iwd-tab-'+jQuery(this).data('tab')).show();
        return false; 
    }); 
}
if(jQuery('.iwd-nav-tab-sub').length > 0) {
    jQuery(document).on('click', '.iwd-nav-tab-sub', function(event) {
        event.preventDefault(); 
        jQuery('.iwd-tab-sub').hide(); 
        jQuery('#iwd-tab-'+jQuery(this).data('tab')+'-sub').show();
        return false; 
    }); 
}

jQuery(document).on('submit', '.iwd-be-form', function(event){

    event.preventDefault(); 

    jQuery.ajax({
        url: '/wp-admin/admin-ajax.php', 
        type: 'post', 
        dataType: 'JSON',
        data: jQuery(this).serialize()
    }).done(function(data){
        if(data.success == true) {
            jQuery('#iwd-success').fadeIn().delay(5000).fadeOut();
        }
    });  
}); 

jQuery(document).ready(function(){
    if(jQuery('#iwddatatable').length > 0 ) {

        var iwdtable = jQuery('#iwddatatable').DataTable({       
            buttons : [
                'copy', 'excel', 'pdf', 'print'
            ],
            language : {
                "emptyTable": "Keine Daten in der Tabelle vorhanden",
                "info": "_START_ bis _END_ von _TOTAL_ Einträgen",
                "infoEmpty": "Keine Daten vorhanden",
                "infoFiltered": "(gefiltert von _MAX_ Einträgen)",
                "infoThousands": ".",
                "loadingRecords": "Wird geladen ..",
                "processing": "Bitte warten ..",
                "paginate": {
                    "first": "Erste",
                    "previous": "Zurück",
                    "next": "Nächste",
                    "last": "Letzte"
                },
                "aria": {
                    "sortAscending": ": aktivieren, um Spalte aufsteigend zu sortieren",
                    "sortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
                },
                "select": {
                    "rows": {
                        "_": "%d Zeilen ausgewählt",
                        "1": "1 Zeile ausgewählt"
                    },
                    "1": "1 Eintrag ausgewählt",
                    "2": "2 Einträge ausgewählt",
                    "_": "%d Einträge ausgewählt",
                    "cells": {
                        "1": "1 Zelle ausgewählt",
                        "_": "%d Zellen ausgewählt"
                    },
                    "columns": {
                        "1": "1 Spalte ausgewählt",
                        "_": "%d Spalten ausgewählt"
                    }
                },
                "buttons": {
                    "print": "Drucken",
                    "copy": "Kopieren",
                    "copyTitle": "In Zwischenablage kopieren",
                    "copySuccess": {
                        "_": "%d Zeilen kopiert",
                        "1": "1 Zeile kopiert"
                    },
                    "collection": "Aktionen <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
                    "colvis": "Spaltensichtbarkeit",
                    "colvisRestore": "Sichtbarkeit wiederherstellen",
                    "copyKeys": "Drücken Sie die Taste <i>ctrl<\/i> oder <i>⌘<\/i> + <i>C<\/i> um die Tabelle<br \/>in den Zwischenspeicher zu kopieren.<br \/><br \/>Um den Vorgang abzubrechen, klicken Sie die Nachricht an oder drücken Sie auf Escape.",
                    "csv": "CSV",
                    "excel": "Excel",
                    "pageLength": {
                        "-1": "Alle Zeilen anzeigen",
                        "1": "Eine Zeile anzeigen",
                        "_": "%d Zeilen anzeigen"
                    },
                    "pdf": "PDF"
                },
                "autoFill": {
                    "cancel": "Abbrechen",
                    "fill": "Alle Zellen mit <i>%d<i> füllen<\/i><\/i>",
                    "fillHorizontal": "Alle horizontalen Zellen füllen",
                    "fillVertical": "Alle vertikalen Zellen füllen",
                    "info": "Bitte wählen Sie die gewünschte Aktion aus:"
                },
                "decimal": ",",
                "search": "Suche:",
                "searchBuilder": {
                    "add": "Bedingung hinzufügen",
                    "button": {
                        "0": "Such-Baukasten",
                        "_": "Such-Baukasten (%d)"
                    },
                    "condition": "Bedingung",
                    "conditions": {
                        "date": {
                            "after": "Nach",
                            "before": "Vor",
                            "between": "Zwischen",
                            "empty": "Leer",
                            "not": "Nicht",
                            "notBetween": "Nicht zwischen",
                            "notEmpty": "Nicht leer",
                            "equals": "Gleich"
                        },
                        "number": {
                            "between": "Zwischen",
                            "empty": "Leer",
                            "equals": "Entspricht",
                            "gt": "Größer als",
                            "gte": "Größer als oder gleich",
                            "lt": "Kleiner als",
                            "lte": "Kleiner als oder gleich",
                            "not": "Nicht",
                            "notBetween": "Nicht zwischen",
                            "notEmpty": "Nicht leer"
                        },
                        "string": {
                            "contains": "Beinhaltet",
                            "empty": "Leer",
                            "endsWith": "Endet mit",
                            "equals": "Entspricht",
                            "not": "Nicht",
                            "notEmpty": "Nicht leer",
                            "startsWith": "Startet mit"
                        },
                        "array": {
                            "equals": "ist gleich",
                            "empty": "ist leer",
                            "contains": "enthält",
                            "not": "ist ungleich",
                            "notEmpty": "ist nicht leer",
                            "without": "aber nicht"
                        }
                    },
                    "data": "Daten",
                    "deleteTitle": "Filterregel entfernen",
                    "leftTitle": "Äußere Kriterien",
                    "logicAnd": "UND",
                    "logicOr": "ODER",
                    "rightTitle": "Innere Kriterien",
                    "title": {
                        "0": "Such-Baukasten",
                        "_": "Such-Baukasten (%d)"
                    },
                    "value": "Wert",
                    "clearAll": "Alle löschen"
                },
                "searchPanes": {
                    "clearMessage": "Leeren",
                    "collapse": {
                        "0": "Suchmasken",
                        "_": "Suchmasken (%d)"
                    },
                    "countFiltered": "{shown} ({total})",
                    "emptyPanes": "Keine Suchmasken",
                    "loadMessage": "Lade Suchmasken..",
                    "title": "Aktive Filter: %d",
                    "count": "Anzahl"
                },
                "searchPlaceholder": "Suchbegriff eingeben",
                "thousands": ".",
                "zeroRecords": "Keine passenden Einträge gefunden",
                "lengthMenu": "_MENU_ Zeilen anzeigen",
                "datetime": {
                    "previous": "Vorher",
                    "next": "Nachher",
                    "hours": "Stunden",
                    "minutes": "Minuten",
                    "seconds": "Sekunden",
                    "unknown": "Unbekannt"
                },
                "editor": {
                    "close": "Schließen",
                    "create": {
                        "button": "Neu",
                        "title": "Neuen Eintrag erstellen",
                        "submit": "Neu"
                    },
                    "edit": {
                        "button": "Ändern",
                        "title": "Eintrag ändern",
                        "submit": "ändern"
                    },
                    "remove": {
                        "button": "Löschen",
                        "title": "Löschen",
                        "submit": "Löschen",
                        "confirm": {
                            "_": "Sollen %d Zeilen gelöscht werden?",
                            "1": "Soll diese Zeile gelöscht werden?"
                        }
                    },
                    "error": {
                        "system": "Ein Systemfehler ist aufgetreten"
                    },
                    "multi": {
                        "title": "Mehrere Werte",
                        "info": "Die ausgewählten Elemente enthalten mehrere Werte für dieses Feld. Um alle Elemente für dieses Feld zu bearbeiten und auf denselben Wert zu setzen, klicken oder tippen Sie hier, andernfalls behalten diese ihre individuellen Werte bei.",
                        "restore": "Änderungen zurücksetzen",
                        "noMulti": "Dieses Feld kann nur einzeln bearbeitet werden, nicht als Teil einer Mengen-Änderung."
                    }
                }
            }  
        });    
        
        iwdtable.buttons().container().insertBefore( '#iwddatatable_filter' );
   }
}); 
