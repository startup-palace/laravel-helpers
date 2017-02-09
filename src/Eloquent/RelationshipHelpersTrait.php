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
        $relationKeyName = $this->getRelationModelKeyName($relation);

        $this->{$relation}()
            ->whereNotIn($relationKeyName, $this->{$relation}->pluck($relationKeyName)->filter())
            ->delete();

        $this->{$relation}()
            ->saveMany($this->{$relation});

        return $this;
    }

    /**
     * Synchronize a hasOne relation.
     * @param   String   $relation   Relation's name
     * @return  Illuminate\Database\Eloquent\Model
     */
    protected function syncHasOneRelation($relation)
    {
        $this->{$relation}()->save($this->{$relation});

        return $this;
    }

    /**
     * Manually define a hasMany relation's items.
     * @param String    $relation   Relation's name
     * @param array|Illuminate\Support\Collection   $items  Items of the relation
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function setHasManyItems($relation, $items)
    {
        $relatedModel = $this->getRelationModel($relation);

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

    /**
     * Manually define a hasOne relation's items.
     * @param String    $relation   Relation's name
     * @param array $item   Item of the relation
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function setHasOneItem($relation, $data)
    {
        $relatedModel = $this->getRelationModel($relation);

        $item = $relatedModel->newInstance($data);

        if ($item->exists = array_key_exists($relatedModel->getKeyName(), $data)) {
            $item->{$relatedModel->getKeyName()} = $data[$relatedModel->getKeyName()];
        }

        $this->setRelation(
            $relation,
            $item
        );

        return $this;
    }

    /**
     * Get relation's model
     * @param  string   $relation   Relation's name
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function getRelationModel($relation)
    {
        return $this->{$relation}()
            ->getModel();
    }

    /**
     * Get relation's model primary key name
     * @param  string   $relation   Relation's name
     * @return string
     */
    protected function getRelationModelKeyName($relation)
    {
        return $this->getRelationModel($relation)
            ->getKeyName();
    }
}
