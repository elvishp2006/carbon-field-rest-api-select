/**
 * The external dependencies.
 */
import {
  compose, withHandlers, withState, setStatic,
} from 'recompose';

import he from 'he';
import React from 'react';
import Select from 'react-select/lib/Async';
import t from 'prop-types';

/**
 * The internal dependencies.
 */
import Field from 'fields/components/field';
import withStore from 'fields/decorators/with-store';
import withSetup from 'fields/decorators/with-setup';

export const RestApiSelectField = ({
  name, field, handleChange, loadOptions, selected,
}) => (
  <Field field={field}>
    <Select
      id={field.id}
      name={name}
      defaultValue={field.value}
      disabled={!field.ui.is_visible}
      value={selected}
      onChange={handleChange}
      defaultOptions
      loadOptions={loadOptions}
      isClearable
    />
  </Field>
);

RestApiSelectField.propTypes = {
  name: t.string.isRequired,
  field: t.shape({
    id: t.string,
    value: t.any,
  }).isRequired,
  handleChange: t.func.isRequired,
  loadOptions: t.func.isRequired,
  selected: t.shape({
    value: t.any,
    label: t.string,
  }),
};

RestApiSelectField.defaultProps = {
  selected: null,
};

const resolve = (path, obj) => path.split('.').reduce((prev, curr) => (prev ? prev[curr] : null), obj);

export const enhance = compose(
  withStore(),
  withSetup(),
  withState('selected', 'setSelected'),
  withHandlers({
    handleChange: ({ field, setFieldValue, setSelected }) => (selected) => {
      setSelected(selected);

      if (selected) {
        setFieldValue(field.id, selected.value);
      }
    },

    loadOptions: ({ field, setSelected }) => (inputValue) => {
      if (field.value && !inputValue) {
        return fetch(`${field.endpoint}/${field.value}`)
          .then(response => response.json())
          .then((data) => {
            const option = {
              value: resolve(field.endpoint_value_path, data),
              label: he.decode(resolve(field.endpoint_label_path, data)),
            };

            setSelected(option);

            return [option];
          })
          .catch(() => {
            const option = {
              value: field.value,
              label: '...',
            };

            setSelected(option);

            return [option];
          });
      }

      return fetch(`${field.endpoint}/?${field.endpoint_search_param}=${inputValue}`)
        .then(response => response.json())
        .then(json => json.map(data => ({
          value: resolve(field.endpoint_value_path, data),
          label: he.decode(resolve(field.endpoint_label_path, data)),
        })));
    },
  }),
);

export default setStatic('type', ['rest_api_select'])(enhance(RestApiSelectField));
