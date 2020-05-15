<script>
  const WEBROOT = '/';
  const ASSETS = '{{ asset('') }}';
  const IMAGES_FORMATS = {!! json_encode(config('images.formats'), JSON_PRETTY_PRINT) !!};
  const FIELDS = {!! json_encode(Backender\Contents\Fields\FieldConfig::get(), JSON_PRETTY_PRINT) !!};
  const WIDGETS = {!! json_encode(Backender\Contents\Widgets\WidgetConfig::get(), JSON_PRETTY_PRINT) !!};
  const CURRENT_USER = {!! Auth::user() ? json_encode(Auth::user(), JSON_PRETTY_PRINT) : 'null' !!};
  const LANGUAGES = {!! json_encode(Backender\Contents\Entities\Language::orderBy('name', 'DESC')->get(), JSON_PRETTY_PRINT) !!};
  const TYPOLOGIES = {!! json_encode(Backender\Contents\Entities\Typology::all(), JSON_PRETTY_PRINT) !!};
  const ROW_SETTINGS = ['htmlId','htmlClass','hasContainer','textAlign'];
  const COL_SETTINGS = ['htmlId','htmlClass','textAlign','stripped','labelAlign','valueAlign','display'];
  const PAGE_SETTINGS = ['htmlClass','pageType'];
  const CONTENT_SETTINGS = ['htmlClass'];
  const CATEGORIES = {!! json_encode(Backender\Contents\Entities\Category::all(), JSON_PRETTY_PRINT) !!};
  const DEFAULT_LOCALE = '{{ Backender\Contents\Entities\Language::getDefault() ? Backender\Contents\Entities\Language::getDefault()->iso : ''}}';
  const ROLES = {!! json_encode(config('roles'), JSON_PRETTY_PRINT) !!};
  const FONTS = {!! json_encode(config('fonts'), JSON_PRETTY_PRINT) !!};
</script>
