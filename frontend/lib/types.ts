export enum ColorTypes {
  PRIMARY = "primary",
  DEFAULT = "default",
  WHITE = "white"
}

export enum ErrorMessage {
  UNKWOWN = "Произошла непредвиденная ошибка. Попробуйте еще раз",
}

export interface ModelResourseWrapper<T> {
  data: T
}
