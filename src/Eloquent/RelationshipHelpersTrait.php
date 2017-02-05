<?php

namespace StartupPalace\LaravelHelpers\Eloquent;

trait RelationshipHelpersTrait
{
    /**
     * Synchronize a hasMany relation, deleting old items, updating existing
     * and creating new ones.
     * @param   String   $relation   Relation's name
     * @return  Illuminate\Database\Eloquent\Model
     */
    protected function syncHasManyRelation($relation)
    {
        $relationKeyName = $this->{$relation}()
            ->getModel()
            ->getKeyName();

        $this->{$relation}()
            ->whereNotIn($relationKeyName, $this->{$relation}->pluck($relationKeyName)->filter())
            ->delete();

        $this->{$relation}()
            ->saveMany($this->{$relation});

        return $this;
    }

    /**
     * Manually define a relation's items
     * @param String    $relation   Relation's name
     * @param array|Illuminate\Support\Collection   $items  Items of the relation
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function setRelationItems($relation,  $items)
    {
        $relatedModel = $this->{$relation}()->getModel();

        if (is_array($items)) {
            $items = collect($items);
        }

        $this->setRelation(
            $relation,
            $items->map(function ($data) use ($relatedModel) {
                $item = $relatedModel->newInstance($data);

                if ($item->exists = array_key_exists($relatedModel->getKeyName(), $data)) {
                    $item->{$relatedModel->getKeyName()} = $data[$relatedModel->getKeyName()];
                }

                return $item;
            })
        );

        return $this;
    }
}
