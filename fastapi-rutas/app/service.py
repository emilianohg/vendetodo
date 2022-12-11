import pandas as pd
import itertools

class RutasService:
    def __init__(
        self,
        orden_id: int,
        total_estantes: int,
        total_secciones: int,
    ):
        self.orden_id = orden_id
        self.total_secciones = total_secciones + 1
        self.total_estantes = total_estantes

    def __get_paths(self, start, waypoints, width, height):
        data = []

        for start in [start, *waypoints]:

            for end in waypoints:

                if (start == end):
                    continue

                # En el mismo estante
                if (start[1] == end[1]):
                    data.append([
                        start,
                        end,
                        [start, end],
                        abs(start[0] - end[0])
                    ])
                    continue

                # Diferente estante

                # Izquierda
                path_left = [start, (0, start[1]), (0, end[1]), end]
                if (start == (0, start[1])):
                    path_left = [start, (0, end[1]), end]

                distance_left = start[0] + end[0] + abs(start[1] - end[1])

                # Derecha
                path_right = [start, (width, start[1]), (width, end[1]), end]
                if (start == (width, start[1])):
                    path_right = [start, (width, end[1]), end]

                distance_right = (width - start[0]) + (width - end[0]) + abs(start[1] - end[1])

                # Elegimos izquierda o derecha para llegar al siguiente punto
                if (distance_left < distance_right):
                    data.append([
                        start,
                        end,
                        path_left,
                        distance_left
                    ])
                else:
                    data.append([
                        start,
                        end,
                        path_right,
                        distance_right
                    ])

        return pd.DataFrame(
            data,
            columns=[
                'from',
                'to',
                'path',
                'distance',
            ]
        )

    def __get_list_coords(self, coord_json):
        return [(c['x'], c['y']) for c in coord_json]

    def __get_distance(self, path):
        distance = 0
        fullpath = []

        for i in range(len(path) - 1):

            if (path[i] == path[i + 1]):
                continue

            record = self.df_paths[
                (self.df_paths['from'] == path[i]) & (self.df_paths['to'] == path[i + 1])
            ].iloc[0]

            current_path = record['path']
            distance += int(record['distance'])

            if (i == 0):
                fullpath = current_path
                continue

            fullpath = fullpath + current_path[1:]

        return fullpath, distance

    def get_min_path(self, start, waypoints):

        start_coord = self.__get_list_coords([start])[0]
        waypoints_coords = self.__get_list_coords(waypoints)
        self.df_paths = self.__get_paths(
            start_coord,
            waypoints_coords,
            self.total_secciones,
            self.total_estantes
        )

        path_min = None
        min = 0

        for _path in list(itertools.permutations(waypoints_coords)):
            current_path, distance = self.__get_distance([start_coord, *_path])

            if (min == 0 or distance < min):
                min = distance
                path_min = current_path

        return path_min, min