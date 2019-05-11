import ComponentsMenu from "./controllers/components/menu_controller";
import FieldsTag from "./controllers/fields/tag_controller";

//We can work with this only when we already have an application
if (typeof window.application !== 'undefined') {
    window.application.register('components--menu', ComponentsMenu);
    window.application.register('fields--tag', FieldsTag);
}